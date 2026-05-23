<?php

namespace App\Http\Controllers;

use App\Models\CodigoVerificacion;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class AuthController extends Controller
{
    private function redirectPathForRole(Usuario $usuario): string
    {
        if ($usuario->esAdministrador()) {
            return route('dashboard');
        }

        if ($usuario->esGerente() || $usuario->esCliente()) {
            return route('ventas.index');
        }

        return route('productos.index');
    }

    public function formulario()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'clave' => 'required'
        ]);

        $credenciales = [
            'correo' => $request->correo,
            'password' => $request->clave,
        ];

        if (! Auth::validate($credenciales)) {
            Log::channel('autenticacion')->warning('Login incorrecto', [
                'correo' => $request->correo,
                'ip' => $request->ip()
            ]);

            return back()->withErrors([
                'correo' => 'Credenciales incorrectas'
            ])->onlyInput('correo');
        }

        /** @var Usuario|null $usuario */
        $usuario = Auth::getProvider()->retrieveByCredentials($credenciales);

        if (! $usuario) {
            Log::channel('autenticacion')->warning('Login incorrecto', [
                'correo' => $request->correo,
                'ip' => $request->ip()
            ]);

            return back()->withErrors([
                'correo' => 'Credenciales incorrectas'
            ])->onlyInput('correo');
        }

        $codigo = (string) random_int(100000, 999999);

        CodigoVerificacion::where('usuario_id', $usuario->id)->delete();
        CodigoVerificacion::create([
            'usuario_id' => $usuario->id,
            'codigo' => $codigo,
            'expiracion' => now()->addMinutes(5),
        ]);

        try {
            Mail::raw("Tu codigo de verificacion es: {$codigo}. Expira en 5 minutos.", function ($message) use ($usuario) {
                $message->to($usuario->correo)
                    ->subject('Codigo de verificacion 2FA');
            });
        } catch (Throwable $e) {
            Log::channel('autenticacion')->error('Error al enviar codigo 2FA', [
                'usuario_id' => $usuario->id,
                'ip' => $request->ip(),
                'error' => $e->getMessage(),
            ]);

            return back()->withErrors([
                'correo' => 'No se pudo enviar el codigo de verificacion. Intenta nuevamente.'
            ])->onlyInput('correo');
        }

        $request->session()->put('2fa_usuario_id', $usuario->id);

        Log::channel('autenticacion')->info('Login correcto (fase 1)', [
            'usuario_id' => $usuario->id,
            'correo' => $usuario->correo,
            'ip' => $request->ip()
        ]);

        Log::channel('autenticacion')->info('Codigo 2FA generado', [
            'usuario_id' => $usuario->id,
            'ip' => $request->ip()
        ]);

        return redirect()->route('2fa.form')->with('status', 'Te enviamos un codigo de verificacion a tu correo.');
    }

    public function formularioCodigo(Request $request)
    {
        if (! $request->session()->has('2fa_usuario_id')) {
            return redirect()->route('login');
        }

        return view('auth.verify-code');
    }

    public function verificarCodigo(Request $request)
    {
        $request->validate([
            'codigo' => 'required|digits:6',
        ]);

        $usuarioId = $request->session()->get('2fa_usuario_id');

        if (! $usuarioId) {
            return redirect()->route('login');
        }

        $codigoVerificacion = CodigoVerificacion::where('usuario_id', $usuarioId)
            ->latest('id')
            ->first();

        if (! $codigoVerificacion || $codigoVerificacion->codigo !== $request->codigo) {
            Log::channel('autenticacion')->warning('Codigo invalido', [
                'usuario_id' => $usuarioId,
                'ip' => $request->ip()
            ]);

            return back()->withErrors([
                'codigo' => 'El codigo ingresado es invalido.'
            ]);
        }

        if (now()->greaterThan($codigoVerificacion->expiracion)) {
            Log::channel('autenticacion')->warning('Codigo expirado', [
                'usuario_id' => $usuarioId,
                'ip' => $request->ip()
            ]);

            return back()->withErrors([
                'codigo' => 'El codigo ha expirado. Inicia sesion nuevamente para generar otro.'
            ]);
        }

        Auth::loginUsingId($usuarioId);
        CodigoVerificacion::where('usuario_id', $usuarioId)->delete();
        $request->session()->forget('2fa_usuario_id');
        $request->session()->regenerate();

        Log::channel('autenticacion')->info('Codigo validado correctamente', [
            'usuario_id' => $usuarioId,
            'ip' => $request->ip()
        ]);

        /** @var Usuario $usuario */
        $usuario = Auth::user();

        return redirect()->to($this->redirectPathForRole($usuario));
    }

    public function logout(Request $request)
    {
        Log::channel('autenticacion')->info('Logout', [
            'usuario_id' => Auth::id(),
            'ip' => $request->ip()
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/entrar');
    }
}
