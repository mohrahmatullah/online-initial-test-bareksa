<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Request;
use Session;
use Validator;
use App\Post;
use App\PostTag;
use App\PostTagChain;
use App\PostTopik;
use App\PostTopikChain;

class PostController extends Controller
{
    public function index( Post $p , PostTopik $pt){
    	$input = Input::all();
    	$data['post'] = $this->getPosts(true, $input);
    	$data['topik'] = $this->getTopik( $pt );
    	$data['result'] = $input;
		return view('news.index', $data);
	}

  	public function getPosts($pagination = false, $req = null) {

	    $cat = (isset($req['topik']) && $req['topik'] != 'all' ? $req['topik'] : '');
	    $status = (isset($req['sts']) && $req['sts'] != 'all' ? $req['sts'] : '');
	    $startdate = (isset($req['sd']) ? $req['sd'] : '');
	    $enddate = (isset($req['ed']) ? $req['ed'] : '');

	    $get_posts = Post::join('post_topik_chain', 'post.id', 'post_topik_chain.post')
	      ->join('post_topik', 'post_topik.id', 'post_topik_chain.post_topik')
	      ->select('post.id','post.title','post.created','post.status','post.published','post_topik_chain.post_topik')
	      ->when($cat, function($query, $cat) {
	        return $query->where('post_topik.slug', $cat);
	      })
	      ->when($status, function($query, $status) {
	        return $query->where('post.status', $status);
	      })
	      ->when($startdate, function($query, $startdate) {
	        return $query->where('post.published', '>=', $startdate);
	      })
	      ->when($enddate, function($query, $enddate) {
	        return $query->where('post.published', '<=', $enddate);
	      })
	      ->orderBy('post.published', 'DESC')->get();

	    return $get_posts;
  	}

  	public function getTopik( $pt ){
  		$top = $pt->orderBy('name', 'ASC')->get();
    	return $top;
  	}

  	public function newsUpdate($id = null)
  	{
	      $params = [];

	      if($id){
	          $object = Post::where('id', $id)->first();
	          if(!$object)
	              {
	                  return redirect()->route('/');
	              }
	          $params['title_form'] = "Update News";
	          $params['selected_topik'] = $this->get_selected_topik( $id );
	          $params['selected_tag'] = $this->get_selected_tag( $id );
	      }else{
	          $object = "";
	          $params['title_form'] = "Add News";
	      }

	      $params['news'] = $object;
	      $params['topik'] = PostTopik::get();
	      $params['tag'] = PostTag::get();
	      return view('news.update', $params);
	 }

  	public function saveNews( $id = null ){
	    if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
	      $data = Input::all();

	      if($id == 0){
	        $rules =  ['news_title'  => 'required|unique:post,title' , 'news_slug' => 'required' ,'news_content' => 'required','news_topik' => 'required','news_tag' => 'required','news_status' => 'required'];
	        $atributname = [
	          'news_title.required' => 'The news title field is required.',
	          'news_title.unique' => 'news title can not be the same.'
	        ];
	      }else{
	        $rules =  ['news_title'  => 'required' , 'news_slug' => 'required' ,'news_content' => 'required','news_topik' => 'required','news_tag' => 'required','news_status' => 'required'];
	        $atributname = [
	          'news_title.required' => 'The news title field is required.'
	        ];
	      }      

	      $validator = Validator:: make($data, $rules, $atributname);
	   
	      if($validator->fails()){
	        return redirect()->back()
	        ->withInput()
	        ->withErrors( $validator );

	      }
	      else{
	        // echo "sukses";
	        if($id == 0){
	          $post        =  new Post;
	          $post->title                = Input::get('news_title');
	          $post->content              = Input::get('news_content');
	          $post->slug                 = Input::get('news_slug');
	          $post->status               = Input::get('news_status');
	          $post->created              = date("y-m-d H:i:s", strtotime('now'));

	          if($post->save()){
	                        //save topik
	            if(Input::has('news_topik') && count(Input::get('news_topik'))>0){
	              $cat_array = array();

	              foreach(Input::get('news_topik') as $cat_id){
	                $cat_data = array('post_topik'  =>  $cat_id, 'post'  =>  $post->id );

	                array_push($cat_array, $cat_data);
	              }

	              if(count($cat_array) > 0){
	                PostTopikChain::insert( $cat_array );    
	              }
	            }
	                        //save tag
	            if(Input::has('news_tag') && count(Input::get('news_tag'))>0){
	              $tag_array = array();

	              foreach(Input::get('news_tag') as $tag_id){
	                $tag_data = array('post_tag'  =>  $tag_id, 'post'  =>  $post->id );

	                array_push($tag_array, $tag_data);
	              }

	              if(count($tag_array) > 0){
	                PostTagChain::insert( $tag_array );    
	              }
	            }

	          Session::flash('success-message', "Success add news" );
	          return redirect()->route('/');
	          }
	        }
	        else{
	          $data = array(
	            'title'                => Input::get('news_title'),
	            'content'              => Input::get('news_content'),
	            'slug'                => Input::get('news_slug'),
	            'status'                => Input::get('news_status'),
	            'created'                => date("y-m-d H:i:s", strtotime('now'))
	          );
	          if( Post::where('id', $id)->update($data)){
	                          //save topik
	            $is_object_post_category = PostTopikChain::where('post', $id)->get();

	            if(count($is_object_post_category)>0){
	              PostTopikChain::where('post', $id)->delete();
	            }

	            if(Input::has('news_topik') && count(Input::get('news_topik'))>0){
	              $cat_array = array();

	              foreach(Input::get('news_topik') as $cat_id){
	                $cat_data = array('post_topik'  =>  $cat_id, 'post'  =>  $id );

	                array_push($cat_array, $cat_data);
	              }
	              if(count($cat_array) > 0){
	                PostTopikChain::insert( $cat_array );    
	              }
	            }

	                          //save tag
	            $is_object_post_tag = PostTagChain::where('post', $id)->get();

	            if(count($is_object_post_tag)>0){
	              PostTagChain::where('post', $id)->delete();
	            }
	            if(Input::has('news_tag') && count(Input::get('news_tag'))>0){
	              $tag_array = array();

	              foreach(Input::get('news_tag') as $tag_id){
	                $tag_data = array('post_tag'  =>  $tag_id, 'post'  =>  $id );

	                array_push($tag_array, $tag_data);
	              }

	              if(count($tag_array) > 0){
	                PostTagChain::insert( $tag_array );    
	              }
	            }

	            Session::flash('success-message', "Success update news" );
	            return redirect()->route('/');
	          }

	        }

	      }
	    }
	  }

  	public function tag( PostTag $p ){
    	$data['post'] = $p->all();
		return view('news.tag.index', $data);
	}
  	public function tagUpdate($id = null)
  	{
	      $params = [];

	      if($id){
	          $object = PostTag::where('id', $id)->first();
	          if(!$object)
	              {
	                  return redirect()->route('tag');
	              }
	          $params['title_form'] = "Update Tag";
	      }else{
	          $object = "";
	          $params['title_form'] = "Add Tag";
	      }

	      $params['tag'] = $object;
	      return view('news.tag.update', $params);
	 }

  	public function saveTag($id = Null)
	  {
	      if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
	        $data = Input::all();

	        if($id == 0 ){
	          $rules =  ['tag_name'  => 'required|unique:post_tag,name' , 'tag_slug' => 'required'];
	          $atributname = [
	              'tag_name.required' => 'The tag name field is required.',
	              'tag_name.unique' => 'The tag name can not be the same.',
	              'tag_slug.required' => 'The tag slug field is required.',
	          ];
	        }else{
	          $rules =  ['tag_name'  => 'required' , 'tag_slug' => 'required'];
	          $atributname = [
	              'tag_name.required' => 'The tag name field is required.',
	              'tag_slug.required' => 'The tag slug field is required.',
	          ];
	        }
	     
	        $validator = Validator::make($data, $rules, $atributname);
	        if($validator->fails()){
	          return redirect()->back()
	          ->withInput()
	          ->withErrors( $validator );
	        }
	        else{

	          if($id == 0 ){
	              $p        =  new PostTag; 

	              $p->name                 = Input::get('tag_name');
	              $p->slug                 = Input::get('tag_slug');
	              $p->created              = date("y-m-d H:i:s", strtotime('now'));
	              $p->save();

	              Session::flash('success-message', "Success add tag" );
	              return redirect()->route('tag');

	          }else{

	              $data = array(
	                'name'                => Input::get('tag_name'),
	                'slug'                => Input::get('tag_slug'),
	                'updated'             => date("y-m-d H:i:s", strtotime('now'))
	              );
	              PostTag::where('id', $id)->update($data);

	              Session::flash('success-message', "Success update tag" );
	              return redirect()->route('tag');

	          }
	        }
	      }
	  }

	public function topik( PostTopik $p ){
    	$data['post'] = $p->all();
		return view('news.topik.index', $data);
	}

	public function topikUpdate($id = null)
  	{
	      $params = [];

	      if($id){
	          $object = PostTopik::where('id', $id)->first();
	          if(!$object)
	              {
	                  return redirect()->route('topik');
	              }
	          $params['title_form'] = "Update Topik";
	      }else{
	          $object = "";
	          $params['title_form'] = "Add Topik";
	      }

	      $params['topik'] = $object;
	      return view('news.topik.update', $params);
	 }

	public function saveTopik($id = Null)
	  {
	      if( Request::isMethod('post') && Session::token() == Input::get('_token') ){
	        $data = Input::all();

	        if($id == 0 ){
	          $rules =  ['topik_name'  => 'required|unique:post_topik,name' , 'topik_slug' => 'required'];
	          $atributname = [
	              'topik_name.required' => 'The topik name field is required.',
	              'topik_name.unique' => 'The topik name can not be the same.',
	              'topik_slug.required' => 'The topik slug field is required.',
	          ];
	        }else{
	          $rules =  ['topik_name'  => 'required' , 'topik_slug' => 'required'];
	          $atributname = [
	              'topik_name.required' => 'The topik name field is required.',
	              'topik_slug.required' => 'The topik slug field is required.',
	          ];
	        }
	     
	        $validator = Validator::make($data, $rules, $atributname);
	        if($validator->fails()){
	          return redirect()->back()
	          ->withInput()
	          ->withErrors( $validator );
	        }
	        else{

	          if($id == 0 ){
	              $p        =  new PostTopik; 

	              $p->name                 = Input::get('topik_name');
	              $p->slug                 = Input::get('topik_slug');
	              $p->created              = date("y-m-d H:i:s", strtotime('now'));
	              $p->save();

	              Session::flash('success-message', "Success add topik" );
	              return redirect()->route('topik');

	          }else{

	              $data = array(
	                'name'                => Input::get('topik_name'),
	                'slug'                => Input::get('topik_slug'),
	                'updated'             => date("y-m-d H:i:s", strtotime('now'))
	              );
	              PostTopik::where('id', $id)->update($data);

	              Session::flash('success-message', "Success update topik" );
	              return redirect()->route('topik');

	          }
	        }
	      }
	  }
	public function get_selected_topik( $post_id ){
	    $selected = array();
	    $selected_category = PostTopikChain::where('post', $post_id)->get();
	    if(count($selected_category) > 0){
	      $category_id = array();
	      foreach($selected_category as $s)
	      {      
	        $data = $s->post_topik;
	        array_push($category_id, $data);
	      }
	      $selected = $category_id;
	    }
	    return $selected;
	  }

  	public function get_selected_tag( $post_id ){
    	$selected = array();
	    $selected_tag = PostTagChain::where('post', $post_id)->get();
	    if(count($selected_tag) > 0){
	      $tag_id = array();
	      foreach($selected_tag as $s)
	      {      
	        $data = $s->post_tag;
	        array_push($tag_id, $data);
	      }
	      $selected = $tag_id;
	    }
	    return $selected;
  	}

	public function deletedAjax(){
    $input = Request::all();
    /*dd($input);*/
      if($input['data']['id'] && $input['data']['track']){
	    if($input['data']['track'] == 'list_topik'){
	      if(PostTopik::where('id', $input['data']['id'])->delete()){
	        return response()->json(array('delete' => true));
	      }
	    }
	    if($input['data']['track'] == 'list_tag'){
	      if(PostTag::where('id', $input['data']['id'])->delete()){
	        return response()->json(array('delete' => true));
	      }
	    }
	    if($input['data']['track'] == 'list_news'){
	      if(Post::where('id', $input['data']['id'])->delete()){
	          PostTopikChain::where('post', $input['data']['id'])->delete();
              PostTagChain::where('post', $input['data']['id'])->delete();
	        return response()->json(array('delete' => true));
	      }
	    }

	  }
  }
}
