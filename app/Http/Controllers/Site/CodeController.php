<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\ObdCode;
use Illuminate\Http\Request;

class CodeController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $results = [];

        if ($query) {
            $results = ObdCode::where('code', 'LIKE', '%' . $query . '%')
                ->orWhereHas('translations', function ($q) {
                    $q->where('language_code', app()->getLocale());
                })
                ->get();
        }


        return view('site.code.index', compact('query', 'results'));
    }

    public function show($code)
    {
        $obdCode = ObdCode::where('code', $code)->firstOrFail();

        $translation = $obdCode->translations()
            ->where('language_code', app()->getLocale())
            ->first();

        // Fallback لجميع الحقول من ObdCode مباشرة
        $translation = $translation ?? (object)[
            'title' => $obdCode->title,
            'description' => $obdCode->description ?? '',
            'symptoms' => $obdCode->symptoms ?? '',
            'causes' => $obdCode->causes ?? '',
            'solutions' => $obdCode->solutions ?? '',
            'diagnosis' => $obdCode->diagnosis ?? '',
            'severity' => $obdCode->severity ?? '',
            'status' => $obdCode->status ?? '',
            'source_url' => $obdCode->source_url ?? '',
            'lang' => $obdCode->lang ?? '',
            'image' => $obdCode->image ?? '',
            'category' => $obdCode->category ?? '',
            'created_at' => $obdCode->created_at ?? '',
            'updated_at' => $obdCode->updated_at ?? '',
            
        ];

        return view('site.code.show', compact('obdCode', 'translation'));
    }
}
