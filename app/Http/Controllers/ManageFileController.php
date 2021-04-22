<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Events\fileSendMessage;

class ManageFileController extends Controller
{
    public function index(){
        return view('home');
    }

    public function UpdateFile(Request $request){

        // Generate your random pusher keys with this and configure in .env bin2hex(random_bytes(10))
        $target_dir = "public/shared_files/";

        $file_paths = [];
        if( isset($request->files) && $files=$request->file('files')){
            
            foreach ($files as $file) {
                $only_file_name = str_replace(",","",$file->getClientOriginalName());
                $filename= time().'-'.$only_file_name;
                $ext = strtolower($file->extension());

                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                    if (!file_exists($target_dir)) {
                        $data['status_code'] = 0; 
                        $data['status_text'] = 'Error in folder creation try again';
                        return json_encode($data);
                    }
                }
                $path = public_path($target_dir . '/' . $filename);

                $img = $file->move($target_dir, $filename);
                $fpath = "/" . $target_dir . $filename;
                $file_paths[] = ['path'=>url($fpath),'name'=>$only_file_name,'ext'=>$ext];
            }
        }
        if(count($file_paths)){
            $send_response = ['status_code'=>1,'status_text'=>'File sent successfully!','data'=>$file_paths,'mid'=>bin2hex(time().random_bytes(5))];
            echo json_encode($send_response);
            event(new fileSendMessage($send_response));
        }else{
            echo json_encode(['status_code'=>0,'status_text'=>'File upload failed']);
        }
    }
}
