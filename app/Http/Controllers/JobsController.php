<?php

namespace App\Http\Controllers;
use App\Job;
use App\User;
use Redirect;

use App\Http\Requests\PostFormRequest;

//Refer to Model


use Illuminate\Http\Request;

use App\Http\Requests;

class JobsController extends Controller
{
    public function index()
    {
        ///////////////////////////////////////
        $jobs = Job::where('active', 1)->orderBy('created_at', 'desc')->paginate(5);

        $title = 'Latest Jobs';

        //will return last 5 posts with titles.

        return view('home')->withPosts($jobs)->withTitle($title);
    }

    public function create(Request $request)
    {

        if($request->user()->can_post())
        {
            return view('jobs.create');
        } 
        else
        {
            return redirect('/')->withErrors("You don't have permission to write a post");
        }

    }

    //looking for a specific type of request



    public function store(PostFormRequest $request) 

    {
        $job = new Job();
        $job->title = $request->get('title');
        $job->body = $request->get('body');

        $job->slug = str_slug($job->title);
        $job->author_id = $request->user()->id;


        if($request->has('save'))
        {

            $job->active = 0;
            $message = "Post saved successfully";

        }
        else
        {

            $job->active = 1;
            $message = 'Post published Successfully';
        }

        $job->save();
        return redirect('edit/'.$job->slug)->withMessage($message);




    }

    public function show($slug) 
    {


        $job  = Job::where('slug', $slug)->first();
        if(!$job)
        {
            return redirect('/')->withErrors('requested page not found');
        }

        $comments = $job->comments;
        return view('jobs.show')->withPost($job)->withComments($comments);

    }

    public function edit(Request $request, $slug)
    {

        $job  = Job::where('slug', $slug)->first();

        if($job && ($request->user()->id == $job->author_id || $request->user()->is_admin() ))
        {

            return view('jobs.edit')->withPost($job);

        }
            return redirect('/')->withErrors("You cant handle this edit!");
    }




    public function update(Request $request)
    {


        $job_id = $request->input('job_id');


        $job = Job::find($job_id);



        if($job && ($request->user()->id == $job->author_id || $request->user()->is_admin() ))

        {

                $title = $request->input('title');
                $slug = str_slug($title);
                $duplicate = Job::where('slug', $slug)->first();

                if($duplicate)
                {
                    if($duplicate->id != $job_id)
                    {
                        return redirect('edit/'.$job->slug)->withErrors('Title already exist')->withInput();
                    }

                    else
                    {
                        $job->slug = $slug;
                    }

                }

                $job->title = $title;
                $job->body = $request->input('body');
                if($request->has('save'))
                {

                    $job->active = 0;
                    $message = 'Post saved successfully';
                    $landing = 'edit/'.$job->slug;
                }

                else{

                    $job->active = 1;
                    $message = "Post updated successfully";
                    $landing = $job->slug;
                }

                $job->save();
                    return redirect($landing)->withMessage($message);

        }
        else
        {
            return redirect('/')->withErrors('You cant do it');
        }



    }

    public function destroy(Request $request, $id)
    {

        $job = Job::find($id);
                if($job && ($request->user()->id == $job->author_id || $request->user()->is_admin() ))
                {

                    $job->delete();
                    $data['message'] = 'Post deleted sucka';
                }
                else
                {
                    $data['errors'] = 'You shall not Delete this';
                }

                return redirect('/')->with($data);


    }


}
