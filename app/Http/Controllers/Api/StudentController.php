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
        $servername = 'localhost';
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $dbname = "itdevir_test";
        
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
        }
        $sql='';
        
        for($i=0;$i<$request->count;$i++){
          $sql.='insert into students (fname,lname,age,code,class,fatherName,status) values (fname,lname,age,code,class,fatherName,status)';
        }

       if(mysqli_multi_query($conn, $sql)) {
         //echo "New records created successfully";
       } 
       else{
         echo "Error: " . $sql . "<br>" . mysqli_error($conn);
       }

       mysqli_close($conn);

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
        $servername = 'localhost';
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $dbname = "itdevir_test";

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
