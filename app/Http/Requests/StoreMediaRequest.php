<?php

namespace App\Http\Requests;

use App\Models\Media;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // PATCH dan PUT sama-sama memperbarui sebagian data
        $isUpdate = in_array($this->method(), ['PATCH', 'PUT'], true);
        $required = $isUpdate ? 'sometimes' : 'required';

        $routeMedia = $this->route('media');
        $mediaId = $routeMedia instanceof Media ? $routeMedia->id : $routeMedia;

        $uniqueTitle = Rule::unique('media', 'title');

        if ($mediaId) {
            $uniqueTitle->ignore($mediaId);
        }

        return [
            'title' => [$required, 'string', 'max:255', $uniqueTitle],
            'type'  => [$required, 'string', 'max:50'],
            'genre' => [$required, 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul media wajib diisi.',
            'title.unique'   => 'Judul media sudah digunakan.',
            'type.required'  => 'Jenis media wajib diisi.',
            'genre.required' => 'Genre media wajib diisi.',
        ];
    }
}
