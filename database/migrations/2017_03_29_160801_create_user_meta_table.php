<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_meta', function (Blueprint $table) {
        	$table->integer('user_id')->unsigned()->unique();
			$table->string('biography')->nullable();
			$table->string('job')->nullable();
			$table->string('twitter')->nullable();
			$table->string('instagram')->nullable();
			$table->string('facebook')->nullable();
			$table->string('github')->nullable();
			$table->string('youtube')->nullable();
			$table->string('googleplus')->nullable();
			$table->string('stackoverflow')->nullable();
			$table->string('bitbucket')->nullable();
			$table->string('linkedin')->nullable();
			$table->string('tumblr')->nullable();
			$table->string('twitch')->nullable();
			$table->string('vimeo')->nullable();

			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('user_meta');
    }
}

/*
SELECT
  users.
FROM users as users;

SELECT
  usermeta_description.user_id      AS user_id,
  usermeta_description.meta_value   AS user_biography,
  usermeta_twitter.meta_value       AS user_twitter,
  usermeta_instagram.meta_value     AS user_instagram,
  usermeta_facebook.meta_value      AS user_facebook,
  usermeta_github.meta_value        AS user_github,
  usermeta_youtube.meta_value       AS user_youtube,
  usermeta_googleplus.meta_value    AS user_googleplus,
  usermeta_stackoverflow.meta_value AS user_stackoverflow,
  usermeta_bitbucket.meta_value     AS user_bitbucket,
  usermeta_linkedin.meta_value      AS user_linkedin,
  usermeta_bitbucket.meta_value     AS user_tumblr,
  usermeta_twitch.meta_value        AS user_twitch,
  usermeta_vimeo.meta_value         AS user_vimeo
FROM gt_usermeta AS usermeta_description
  LEFT JOIN gt_usermeta AS usermeta_twitter
    ON usermeta_description.user_id = usermeta_twitter.user_id AND usermeta_twitter.meta_key = "twitter"
  LEFT JOIN gt_usermeta AS usermeta_instagram
    ON usermeta_description.user_id = usermeta_instagram.user_id AND usermeta_instagram.meta_key = "instagram"
  LEFT JOIN gt_usermeta AS usermeta_facebook
    ON usermeta_description.user_id = usermeta_facebook.user_id AND usermeta_facebook.meta_key = "facebook"
  LEFT JOIN gt_usermeta AS usermeta_github
    ON usermeta_description.user_id = usermeta_github.user_id AND usermeta_github.meta_key = "github"
  LEFT JOIN gt_usermeta AS usermeta_youtube
    ON usermeta_description.user_id = usermeta_youtube.user_id AND usermeta_youtube.meta_key = "youtube"
  LEFT JOIN gt_usermeta AS usermeta_googleplus
    ON usermeta_description.user_id = usermeta_googleplus.user_id AND usermeta_googleplus.meta_key = "googleplus"
  LEFT JOIN gt_usermeta AS usermeta_stackoverflow
    ON usermeta_description.user_id = usermeta_stackoverflow.user_id AND
       usermeta_stackoverflow.meta_key = "stackoverflow"
  LEFT JOIN gt_usermeta AS usermeta_bitbucket
    ON usermeta_description.user_id = usermeta_bitbucket.user_id AND usermeta_bitbucket.meta_key = "bitbucket"
  LEFT JOIN gt_usermeta AS usermeta_linkedin
    ON usermeta_description.user_id = usermeta_linkedin.user_id AND usermeta_linkedin.meta_key = "linkedin"
  LEFT JOIN gt_usermeta AS usermeta_tumblr
    ON usermeta_description.user_id = usermeta_tumblr.user_id AND usermeta_tumblr.meta_key = "tumblr"
  LEFT JOIN gt_usermeta AS usermeta_twitch
    ON usermeta_description.user_id = usermeta_twitch.user_id AND usermeta_twitch.meta_key = "twitch"
  LEFT JOIN gt_usermeta AS usermeta_vimeo
    ON usermeta_description.user_id = usermeta_vimeo.user_id AND usermeta_vimeo.meta_key = "vimeo"
WHERE usermeta_description.meta_key = 'description';
 */
