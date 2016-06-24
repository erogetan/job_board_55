<?php

namespace App\Http\Controllers;

use App\Job;
use App\Comment;
use Redirect;

use App\Http\Requests\PostFormRequest;

use Illuminate\Http\Request;

use App\Http\Requests;

class CommentsController extends Controller
{
    




	public function store(Request $request)
	{

		$input['user_id'] = $request->user()->id;
		$input['job_id'] = $request->input('job_id');
		$input['body'] = $request->input('body');
		$slug = $request->input('slug');
		Comment::create($input);

		return redirect($slug)->with('message','Comment published.');
	}






}

