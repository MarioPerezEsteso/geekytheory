<?php

namespace App\Validators;

use App\Http\Controllers\SiteMetaController;
use App\Validators\Base\LaravelValidator;
use App\Validators\Base\ValidableInterface;

class SiteMetaValidator extends LaravelValidator implements ValidableInterface
{
    /**
     * Validation rules.
     * It is empty because SiteMeta can't be created. Just updated.
     */
    protected $rules = array();

    /**
     * Modify the rules for updating a the site meta.
     *
     * @param null $id
     * @return $this|ValidableInterface
     */
    public function update($id = null)
    {
        $this->rules = array(
            'title'         => 'required|max:255',
            'subtitle'      => 'required|max:255',
            'description'   => 'required|max:170',
            'url'           => SiteMetaController::$urlRegexValidator,
            'image'         => 'mimes:jpeg,gif,png',
            'logo'          => 'mimes:jpeg,gif,png',
            'favicon'       => 'mimes:jpeg,gif,png',
            'logo_57'       => 'mimes:jpeg,gif,png',
            'logo_72'       => 'mimes:jpeg,gif,png',
            'logo_114'      => 'mimes:jpeg,gif,png',
        );
        // Add social networks to rules
        foreach (SiteMetaController::$socialNetworks as $socialNetwork) {
            $this->rules[$socialNetwork] = SiteMetaController::$urlRegexValidator;
        }
        return $this;
    }

    /**
     * Validate the menu.
     */
    public function menuPasses()
    {
        $this->rules = array(
            'text' => 'required',
            'link' => SiteMetaController::$urlRegexValidator,
        );
        $valid = true;
        foreach ($this->data as $menuItem) {
            if (!$this->with($menuItem)->passes()) {
                $valid = false;
                break;
            }
        }
        return $valid;
    }
}