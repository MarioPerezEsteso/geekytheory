<?php

namespace App\Validators;

use App\Validators\Base\LaravelValidator;
use App\Validators\Base\ValidableInterface;

class ArticleValidator extends LaravelValidator implements ValidableInterface
{
    /**
     * Validation rules for creating an Article.
     */
    protected $rules = [
        'title' => 'required|unique:posts|max:255',
        'body' => 'required',
        'status' => 'required|in:pending,draft,published,scheduled',
        'description' => 'required|max:170',
        'slug' => 'required|unique:posts',
        'image' => 'mimes:jpeg,gif,png',
        'type'  => 'required|in:article',
    ];

    /**
     * Modify the rules for updating an Article.
     *
     * @param null $id
     * @return $this|ValidableInterface
     */
    public function update($id = null)
    {
        $this->rules = [
            'title' => 'required|unique:posts|max:255,id,' . $id,
            'body' => 'required',
            'status' => 'required|in:pending,draft,published,scheduled',
            'description' => 'required|max:170',
            'image' => 'mimes:jpeg,gif,png',
            'type'  => 'required|in:article',
        ];

        return $this;
    }

    public function updateShares()
	{
		$this->rules = [
			'socialNetwork' => 'required|in:whatsapp,twitter,facebook,google-plus,telegram,mail'
		];

		return $this;
	}
}