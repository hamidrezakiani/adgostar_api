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
        
        $conn1 = mysqli_connect($servername, $username, $password, $dbname);
        $conn2 = mysqli_connect($servername, $username, $password, $dbname);
        $conn3 = mysqli_connect($servername, $username, $password, $dbname);
        $conn4 = mysqli_connect($servername, $username, $password, $dbname);
        $conn5 = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if(!$conn1){die("Connection1 failed: " . mysqli_connect_error());}
        if(!$conn2){die("Connection2 failed: " . mysqli_connect_error());}
        if(!$conn3){die("Connection3 failed: " . mysqli_connect_error());}
        if(!$conn4){die("Connection4 failed: " . mysqli_connect_error());}
        if(!$conn5){die("Connection5 failed: " . mysqli_connect_error());}
        
        
        $sql='';
        
        for($i=0;$i<$request->count/5;$i++){
          $sql.="insert into students values ('hamid','kiani',26,123456,'B1');";
        }
        
        

       if(mysqli_multi_query($conn1, $sql)) {
         //echo "New records created successfully";
       } 
       else{
         echo "Error1: " . $sql . "<br>" . mysqli_error($conn);
       }

       if(mysqli_multi_query($conn2, $sql)) {
         //echo "New records created successfully";
       } 
       else{
         echo "Error2: " . $sql . "<br>" . mysqli_error($conn);
       }
       
       if(mysqli_multi_query($conn3, $sql)) {
         //echo "New records created successfully";
       } 
       else{
         echo "Error3: " . $sql . "<br>" . mysqli_error($conn);
       }
       
       if(mysqli_multi_query($conn4, $sql)) {
         //echo "New records created successfully";
       } 
       else{
         echo "Error4: " . $sql . "<br>" . mysqli_error($conn);
       }
       
       if(mysqli_multi_query($conn5, $sql)) {
         //echo "New records created successfully";
       } 
       else{
         echo "Error5: " . $sql . "<br>" . mysqli_error($conn);
       }
       
       mysqli_close($conn1);
       mysqli_close($conn2);
       mysqli_close($conn3);
       mysqli_close($conn4);
       mysqli_close($conn5);

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
      if($request->flag == 'one')
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
            $conn->exec('insert into students (fname,lname,age,code,class) values (fname,lname,age,code,class)');
          }
          // commit the transaction
          $conn->commit();
          return response()->json(['message' => "500000 rows created successfully"],200);
          } catch(PDOException $e) {
            // roll back the transaction if something failed
            $conn->rollback();
            return response()->json(['message' => "Error: " . $e->getMessage()],200);
         }

      }
      else{
        $servername = 'localhost';
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $dbname = "itdevir_test";
        
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        
        if(!$conn){die("Connection1 failed: " . mysqli_connect_error());}
         $sql = array(); 
         for($i=0;$i<$count;$i++) {
            $sql[] = '("hamid","kiani",26,123456,"B2")';
          }
          mysqli_query($conn,'INSERT INTO students (fname,lname,age,code,class) VALUES '.implode(',', $sql));
          mysqli_close($conn);
          return response()->json(['message' => "500000 rows created successfully"],200);
      }
    }
}
