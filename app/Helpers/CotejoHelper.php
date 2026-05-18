<?php

namespace App\Helpers;

use App\Models\DocumentoAdjunto;

class CotejoHelper
{
    const DOCUMENTOS_COTEJO = [
        'DESARROLLO URBANO' => [
            'Alineamiento y Número Oficial, y uso de suelo' => ['buscar' => ['alineamiento', 'numero oficial', 'uso de suelo']],
            'Uso de suelo específico' => ['buscar' => ['uso de suelo especifico', 'uso de suelo']],
        ],
        'PROTECCIÓN CIVIL' => [
            'Programa interno de protección civil' => ['buscar' => ['programa interno', 'proteccion civil', 'interno']],
        ],
        'UNIVERSAL' => [
            'RFC actualizada' => ['buscar' => ['rfc', 'RFC']],
            'INE Propietario' => ['buscar' => ['ine', 'INE', 'identificacion']],
            'Comprobante de domicilio (Luz)' => ['buscar' => ['luz', 'Luz','domicilio', 'Domicilio' ,'cfe', 'CFE','recibo', 'Recibo', 'electricidad', 'Electricidad']],
            'Comprobante de domicilio (Agua)' => ['buscar' => ['agua', 'Agua']],
            'Comprobante de pago predial' => ['buscar' => ['predial', 'Predial']],
        ],
    ];

    public static function getDocumentosParaCotejo($contribuyenteId)
    {
        $resultados = [];

        foreach (self::DOCUMENTOS_COTEJO as $area => $documentos) {
            foreach ($documentos as $nombre => $config) {
                $estado = self::buscarDocumento($contribuyenteId, $config['buscar']);
                
                $resultados[] = [
                    'area' => $area,
                    'nombre' => $nombre,
                    'estado' => $estado['estado'],
                    'ruta' => $estado['ruta'],
                    'subido_por' => $estado['subido_por']
                ];
            }
        }

        return $resultados;
    }

    private static function buscarDocumento($contribuyenteId, $palabrasBuscar)
{
    // 1. Buscar en documentos_adjuntos
    $documento = DocumentoAdjunto::whereHas('tramiteDocumento', function($q) use ($contribuyenteId) {
        $q->where('contribuyente_id', $contribuyenteId);
    })
    ->where(function($q) use ($palabrasBuscar) {
        foreach ($palabrasBuscar as $palabra) {
            $q->orWhere('nombre_documento', 'LIKE', "%{$palabra}%");
        }
    })
    ->where('mostrar_en_cotejo', true)
    ->first();

    if ($documento) {
        return [
            'estado' => 'activo',
            'ruta' => $documento->archivo_path,
            'subido_por' => $documento->tramiteDocumento->area_id
        ];
    }

    // 2. Buscar en tramites_documentos (documentos finales)
    $tramite = \App\Models\TramiteDocumento::where('contribuyente_id', $contribuyenteId)
        ->where(function($q) use ($palabrasBuscar) {
            foreach ($palabrasBuscar as $palabra) {
                $q->orWhere('tramite', 'LIKE', "%{$palabra}%");
            }
        })
        ->whereNotNull('documento_final_path')
        ->first();

    if ($tramite) {
        return [
            'estado' => 'activo',
            'ruta' => $tramite->documento_final_path,
            'subido_por' => $tramite->area_id
        ];
    }

    return [
        'estado' => 'pendiente',
        'ruta' => null,
        'subido_por' => null
    ];
}
    public static function getNombreArea($areaId)
    {
        $areas = [
            1 => 'Industria y Comercio',
            2 => 'Desarrollo Urbano',
            3 => 'Protección Civil',
            4 => 'Ingresos',
        ];
        return $areas[$areaId] ?? 'Desconocido';
    }
}