<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class downloadImportController extends Controller
{

    protected $apiKeys = [
        'yayimages' => '805c5b60-6bbf-4a94-818c-f8d4cd52ab62',
        'old.yayimages' => '0c3d730f-0564-4d0c-988e-5492e45b78ef',
        'pond5' => '1d8a7f7d-d8de-484a-a22a-6b604382e76f',
    ];

    public function __invoke(Request $request)
    {
        $partner = $this->checkApiKeys($request->header('Authorization'));
        //dd($request->payloads);
        $validated = $request->validate([
            'username' => "required|string|max:255|in:{$partner}",
            'payload.*' => 'required|array|min:1|max:10',
            'payload.*.image_id' => 'required|integer',
            'payload.*.value' => 'required|integer',
            'payload.*.created_at' => 'required|date',
        ]);
        $images = collect($validated['payload']);
        $users = $this->getUsersForImages($images->pluck('image_id'));
        $users = $users->keyBy('id');
        $images->transform(function ($image) use ($partner, $users) {
            unset($image['id']);
            unset($image['updated_at']);
            unset($image['user_id']);
            $image['client'] = $partner;
            $image['uid'] = $users->get($image['image_id'])->id;
            return $image;

        });
        $images->forget('id');
        //dd($users);
        dd($images);
        return ($images->all());
        //dd($request->scripts);

        return $validated;

        // check whether payload matches hash hash is made content+api_key
        // depending of data being imported one always need to set data provider name.
    }

    protected function checkApiKeys($key): string
    {
        $key = str_replace('Bearer ', '', $key);
        $client = array_search($key, $this->apiKeys);
        if (!$client) {
            abort_unless($client, 403, 'Unouthorized');
        }
        return $client;
    }

    protected function getUsersForImages($ids)
    {
        return DB::connection('db1')->table('media')->select('id', 'uid')->whereIn('id', $ids)->get();
    }
}