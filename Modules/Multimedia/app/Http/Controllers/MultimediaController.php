<?php

namespace Modules\Multimedia\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Multimedia\Models\Multimedia;

class MultimediaController extends Controller
{
    public function index()
    {
        $multimediaFiles = Multimedia::paginate(10);
        return view('multimedia::index', compact('multimediaFiles'));
    }

    public function create()
    {
        return view('multimedia::create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file_name' => 'required|string|max:255',
            'file_path' => 'required|string',
            'file_type' => 'nullable|in:VIDEO,PDF,IMAGEN',
            'mime_type' => 'nullable|string|max:50',
            'size' => 'nullable|integer',
            'model_id' => 'required|integer',
            'model_type' => 'nullable|in:raffles,tickets',
        ]);

        // Crear el archivo multimedia
        Multimedia::create([
            'file_name' => $request->input('file_name'),
            'file_path' => $request->input('file_path'),
            'file_type' => $request->input('file_type'),
            'mime_type' => $request->input('mime_type'),
            'size' => $request->input('size'),
            'model_id' => $request->input('model_id'),
            'model_type' => $request->input('model_type'),
        ]);

        return redirect()->route('multimedia.index')->with('success', 'Archivo multimedia creado exitosamente.');
    }

    public function edit($id)
    {
        $multimedia = Multimedia::findOrFail($id);
        return view('multimedia::edit', compact('multimedia'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'file_name' => 'required|string|max:255',
            'file_path' => 'required|string',
            'file_type' => 'nullable|in:VIDEO,PDF,IMAGEN',
            'mime_type' => 'nullable|string|max:50',
            'size' => 'nullable|integer',
            'model_id' => 'required|integer',
            'model_type' => 'nullable|in:raffles,tickets',
        ]);

        $multimedia = Multimedia::findOrFail($id);

        // Actualizar el archivo multimedia
        $multimedia->update([
            'file_name' => $request->input('file_name'),
            'file_path' => $request->input('file_path'),
            'file_type' => $request->input('file_type'),
            'mime_type' => $request->input('mime_type'),
            'size' => $request->input('size'),
            'model_id' => $request->input('model_id'),
            'model_type' => $request->input('model_type'),
        ]);

        return redirect()->route('multimedia.index')->with('success', 'Archivo multimedia actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $multimedia = Multimedia::findOrFail($id);
        $multimedia->delete();

        return redirect()->route('multimedia.index')->with('success', 'Archivo multimedia eliminado exitosamente.');
    }
}
