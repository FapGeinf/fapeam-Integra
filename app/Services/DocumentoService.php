<?php

namespace App\Services;
use App\Models\Documento;
use App\Models\TipoDocumento;
use Illuminate\Support\Facades\Storage;


class DocumentoService
{
    public function getAllDocumentos()
    {
        return Documento::with('tipoDocumento')
            ->orderBy('tipo_id')
            ->orderBy('ano')
            ->get();
    }

    public function getDocumentosAgrupadosPorTipoEAno()
    {
        $documentos = Documento::with('tipoDocumento')
            ->orderBy('tipo_id')
            ->orderBy('ano')
            ->get();

        return $documentos->groupBy('tipo_id')->map(function ($docs) {
            return $docs->groupBy('ano');
        });
    }



    public function getAllTiposDocumentos()
    {
        return TipoDocumento::all();
    }

    public function getDocumentobyId($id)
    {
        return Documento::findOrFail($id);
    }

    public function insertDocumento(array $validatedData)
    {
        $filePath = null;

        if (isset($validatedData['path']) && $validatedData['path'] instanceof \Illuminate\Http\UploadedFile) {
            $file = $validatedData['path'];
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('anexos', $filename, 'public');
        }

        return Documento::create([
            'path' => $filePath,
            'ano' => $validatedData['ano'],
            'tipo_id' => $validatedData['tipo_id']
        ]);


    }

    public function updateDocumento($id, array $validatedData)
    {
        $documento = $this->getDocumentobyId($id);

        if (isset($validatedData['path']) && $validatedData['path'] instanceof \Illuminate\Http\UploadedFile) {
            if ($documento->path && Storage::disk('public')->exists($documento->path)) {
                Storage::disk('public')->delete($documento->path);
            }

            $file = $validatedData['path'];
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('anexos', $filename, 'public');

            $documento->path = $filePath;
        }

        $documento->update([
            'ano' => $validatedData['ano'],
            'tipo_id' => $validatedData['tipo_id'],
            'path' => $documento->path,
        ]);

        return $documento;
    }

    public function deleteDocumento($id)
    {
        $documento = $this->getDocumentobyId($id);

        if ($documento->path && \Storage::disk('public')->exists($documento->path)) {
            Storage::disk('public')->delete($documento->path);
        }

        return $documento->delete();
    }

}