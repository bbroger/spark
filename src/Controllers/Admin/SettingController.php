<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use Respect\Validation\Validator as v;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index($request, $response)
    {
        return $this->render($response, 'admin/settings.twig');
    }

    public function update($request, $response)
    {
        $inputs = $this->validate($request, [
            'app_name' => v::notBlank(),
            'app_url' => v::notBlank(),
            'font-awesome_kit' => v::notBlank(),
            'app_logo' => v::optional(v::uploaded()->image())
        ], [
            'app_name' => 'O nome do site é obrigatório.',
            'app_url' => 'A url do site é obrigatória.',
            'font-awesome_kit' => 'O kit do FontAwesome é obrigatório.',
            'app_logo.uploaded' => 'Tente enviar novamente a logo do site.',
            'app_logo.image' => 'A logo do site precisa ser uma imagem.'
        ]);

        if (
            isset($inputs['app_logo'])
            && $inputs['app_logo']->getError() == UPLOAD_ERR_OK
        ) {
            $inputs['app_logo'] = moveUploadedFile($inputs['app_logo'], PATH_UPLOADED_IMAGES);
        } else {
            unset($inputs['app_logo']);
        }

        foreach ($inputs as $k => $v) {
            $k = str_replace('_', '.', $k);

            if (setting($k) != $v) {
                Setting::where('name', $k)->update(['value' => $v]);
            }
        }

        $this->flash->success('As configurações do seu site foram salvadas com sucesso.');

        return $response->withRedirect(
            ($inputs['app_url'] ?? url()) . '/admin/settings'
        );
    }
}
