<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Representation\AccountService;
use Illuminate\Http\Request;
use App\Models\Student;
use DB;
use PDO;
class StudentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        for($i=0;$i<1600;$i++)
        {
           Student::create($request->all());
        }
        
        //$allTests = Student::all();
        return response()->json(['message' => "500000 rows created successfully"],200);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Student::where('id','>',0)->delete();
        return response()->json(['message' => 'all records were successfully deleted']);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$count)
    {
        $servername = env('DB_HOST').':'.env('DB_PORT');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $dbname = "test";

        try {
          $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
          // set the PDO error mode to exception
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          // begin the transaction
          $conn->beginTransaction();
          // our SQL statements
          for($i=0;$i<$count;$i++){
            $conn->exec('insert into students (fname,lname,age,code,class,fatherName,status) values (fname,lname,age,code,class,fatherName,status)');
          }
          // commit the transaction
          $conn->commit();
          return response()->json(['message' => "500000 rows created successfully"],200);
          } catch(PDOException $e) {
            // roll back the transaction if something failed
            $conn->rollback();
            return response()->json(['message' => "Error: " . $e->getMessage()],200);
         }

       //for($i=0;$i<2100;$i++){
        // DB::insert('insert into students (fname,lname,age,code,class,fatherName,status) values (?,?,?,?,?,?,?)', array($request->fname,$request->lname,$request->age,$request->code,$request->class,$request->fatherName,$request->status));
      // }
        //return response()->json(['message' => "500000 rows created successfully"],200);
    }
}
