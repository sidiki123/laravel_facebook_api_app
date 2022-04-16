<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Exception;
use Facebook\Exceptions\FacebookSDKException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Facebook\Facebook;

class PublicationController extends Controller
{       
    private $api;

    public function __construct(Facebook $fb)
    {
        $this->middleware(function($request, $next) use ($fb) {
            $fb->setDefaultAccessToken(Auth::user()->token);
            $this->api = $fb;
            return $next($request);
        });
    }

    public function getPageAccessToken($page_id) {
        try {
            $response = $this->api->get('/me/accounts/', Auth::user()->token);
        } catch (FacebookSDKException $e) {
            echo 'Erreur GRAPH API'. $e->getMessage();
            exit;
        } catch (FacebookSDKException $e) {
            echo 'Erreur sur le sereur local'. $e->getMessage();
            exit;
        }
        try {
            $pages = $response->getGraphEdge()->asArray();
            foreach ($pages as $key) {
                if ($key['id'] == $page_id) {
                    return $key['access_token'];
                }
            }
        }  catch (FacebookSDKException $e) {
            echo 'Erreur sur le sereur local'. $e->getMessage();
            exit;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publications = Publication::all();
        return view('pages.publications.index',compact('publications'));
    }

    // public function publishPost() {

    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $page_id = Auth::user()->facebook_page_id ?? '';
        try {
            if ($page_id && Auth::user()->token) {
                $id = $request->id;
                $data = Publication::find($id);

                if (in_array($data->type_de_fichier, ['mp4','avi','mkv','png'])) {
                    $type1 = 'video';
                    $type2 = 'description';
                } else {
                    $type1 = 'photos';
                    $type2 = 'message';
                }
                if ($data->facebook_post_id) {
                    $post = $this->api->post('/'. $data->facebook_post_id, [$type2 => $data->message], $this->getPageAccessToken($page_id));
                }
                else {
                    $post = $this->api->post('/'. $page_id . '/'. $type1, array($type2 = $data->message,'source' => $this->api->fileToUpload(public_path('media/'.$data->media))), $this->getPageAccessToken($page_id));
                }
                $post = $post->getGraphNode()->asArray();
                if (empty($data->facebook_post_id)) {
                    if ($post) {
                        $data->facebook_post_id = $post['post_id']??$post['id'];
                        $data->facebook_id = $post['id'];
                        $data->save();
                        $status_code = 200;
                        $msg = 'Post Facebbok créé avec succès';
                    } else {
                        $status_code = 400;
                        $msg = 'Post Facebook non publié';
                    }
                } else {
                    if ($post['success'] == true) {
                        $status_code = 200;
                        $msg = 'Post Facebook mis à jour avec succès';
                    } else {
                        $status_code = 400;
                        $msg = 'Post Facebook non mis à jour';
                    }
                }
            } else {
                if (empty(Auth::user()->token)) {
                    $msg = 'Veuiller générez le token Facebook. > Ici <a href=""'.url("/facebook/profil/informations").'">Profil</a>.';
                } else {
                    $msg = 'Veuiller ajouter id de la page Facebook. > Ici <a href=""'.url("/facebook/profil/informations").'">Profil</a>.';
                }
                $status_code = 400;
            }
            $arr = array("status" => $status_code, "msg" => $msg);

        } catch (QueryException $ex) {
            $msg = $ex->getMessage();
            if (isset($ex->errorInfo[2])) :
                $msg = $ex->errorInfo[2];
            endif;
            $status_code = 400;
            $arr = array("status" => 400, "msg" => $msg, "result" => array());
        } catch (Exception $ex) {
            $msg = $ex->getMessage();
            if (isset($ex->errorInfo[2])) :
                $msg = $ex->errorInfo[2];
            endif;
            $status_code = 400;
            $arr = array("status" => 400, "msg" => $msg, 'line' => $ex->getLine(), "result" => array());
        }
        return \Response::json($arr);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
