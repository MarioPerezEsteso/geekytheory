<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Repositories\SiteMetaRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class CommentEmailController extends Controller
{
	/**
	 * Notify users that their comments have been answered.
	 *
	 * @param $post
	 * @param $comment
	 * @return bool
	 */
	public static function notifyResponse($post, $comment)
	{
		$siteTitle = SiteMetaController::getSiteMeta()->title;
		$urlResponse = PostController::getPostPublicUrlByType($post, false) . '#' . trans('public.comment') . '-' . $comment->id;

		$data = [
			'subject' => trans('email.new_answer_to_your_comment', ['sitetitle' => $siteTitle]),
			'title' => trans('email.someone_answered_your_comment_in', ['sitetitle' => $siteTitle]),
			'siteTitle' => $siteTitle,
			'author' => $comment->author_name,
			'originalComment' => $comment->body,
			'urlResponse' => $urlResponse,
			'to' => $comment->author_email,
		];

		Mail::send('themes.vortex.emails.comment.notifyResponse', $data, function ($message) use ($data) {
			$message->from('no-reply@geekytheory.com', $data['siteTitle']);
			$message->to($data['to']);
			$message->subject($data['subject']);
		});

		return true;
	}
}
