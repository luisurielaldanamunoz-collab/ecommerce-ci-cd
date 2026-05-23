<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVentaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'producto_id' => 'required|exists:productos,id',
            'cliente_id'  => 'required|exists:usuarios,id',
            'total'       => 'required|numeric|min:1',
            'ticket'      => 'nullable|image|max:4096',
        ];
    }

    public function messages(): array
    {
        return [
            'producto_id.required' => 'Debes seleccionar un producto.',
            'producto_id.exists'   => 'El producto seleccionado no existe.',
            'cliente_id.required'  => 'Debes seleccionar un cliente.',
            'cliente_id.exists'    => 'El cliente seleccionado no existe.',
            'total.required'       => 'El total es obligatorio.',
            'total.numeric'        => 'El total debe ser numérico.',
            'total.min'            => 'El total debe ser mayor a 0.',
            'ticket.image'         => 'El ticket debe ser una imagen válida.',
            'ticket.max'           => 'El ticket debe pesar máximo 4 MB.',
        ];
    }
}
