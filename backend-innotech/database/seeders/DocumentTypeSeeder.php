<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentType;

class DocumentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $licenceDocs = [
            'Copie conforme du diplôme du baccalauréat',
            'Certificat de naissance',
            'Photo d’identité',
            'Copie de la carte d’identité nationale (CIN) ou passeport',
            'Exemplaire du règlement intérieur signé'
        ];

        $mastereDocs = [
            'Copie légalisée du diplôme de Licence ou équivalent',
            'Relevés de notes (copies conformes)',
            'Copie conforme du diplôme du baccalauréat',
            'Certificat de naissance',
            'Photo d’identité',
            'Copie de la carte d’identité nationale (CIN) ou passeport',
            'Exemplaire du règlement intérieur signé'
        ];

        foreach ($licenceDocs as $doc) {
            DocumentType::create([
                'name' => $doc,
                'level' => 'Licence',
                'is_required' => true
            ]);
        }

        foreach ($mastereDocs as $doc) {
            DocumentType::create([
                'name' => $doc,
                'level' => 'Mastere',
                'is_required' => true
            ]);
        }
    }
}
