<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:1',
            'existencia' => 'required|integer|min:0',
            'fotos' => 'nullable|array',
            'fotos.*' => 'image|max:4096',
            'categorias' => 'required|array',
            'categorias.*' => 'exists:categorias,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser numérico.',
            'precio.min' => 'El precio debe ser mayor a 0.',
            'existencia.required' => 'La existencia es obligatoria.',
            'existencia.integer' => 'La existencia debe ser un número entero.',
            'existencia.min' => 'La existencia no puede ser negativa.',
            'fotos.array' => 'Las fotos deben enviarse como lista.',
            'fotos.*.image' => 'Cada archivo de fotos debe ser una imagen válida.',
            'fotos.*.max' => 'Cada foto debe pesar máximo 4 MB.',
            'categorias.required' => 'Debes seleccionar al menos una categoría.',
            'categorias.array' => 'Las categorías deben enviarse como arreglo.',
            'categorias.*.exists' => 'Una de las categorías seleccionadas no existe.',
        ];
    }
}
