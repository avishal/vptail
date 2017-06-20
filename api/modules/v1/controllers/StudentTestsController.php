<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\TblTest;
use common\models\TestQuestions;
use common\models\StudentTests;
use common\models\Students;
use yii\helpers\Json;

class StudentTestsController extends ActiveController
{
	public $modelClass = 'common\models\StudentTests';

	public function actionTestResults()
	{
		if (!empty($_POST)) {
			try {
				$testid = $_POST['testid'];
				$studentid = $_POST['studentid'];
				$testModel = StudentTests::findAll(['testid'=>$testid,'studentid'=>$studentid]);
				$allTestResultdata = [];
				$data = [];	
				$data['correctcount'] = 0;
				$data['incorrectcount'] = 0;
				$data['unattempted'] = 0;
				$data['outofmarks']=0;
				$data['marks']=0;
				foreach ($testModel as $model) {
					/*foreach ($model as $key => $value) {
						$data[$key] = $value;
					}*/
					$data['outofmarks']++;
					if($model->correctanswer == 'no')
					{
						$data['incorrectcount']++;
						$data['marks']--;
					}
					else if($model->correctanswer == 'yes')
					{
						$data['correctcount']++;
						$data['marks']++;
					}
					else if($model->correctanswer == 'unattempted')
					{
						$data['unattempted']++;
					}
					$allTestResultdata [] = $data;
				}
				return ['result'=>'success','data'=>[$data]];
				//return ['result'=>'success','data'=>$data,"alldata"=>$allTestResultdata];
				//return ['result'=>'success','data'=>$allTestResultdata,];
			}
			catch (Exception $ex) {
				throw new \yii\web\HttpException(500, 'Internal server error');
			}
		}
		else {
        	throw new \yii\web\HttpException(400, 'invalid request');
    	}
	}

	public function actionSaveTestResults()
	{
		
		$data = file_get_contents("php://input");
		$post = Json::decode($data, true);
		//echo json_encode($post);exit;
		//echo "<pre>"; print_r($post);exit;
		if (!empty($post)) {
			try {

				$testid = $post['testid'];
				$studentid = $post['studentid'];
				
				$studentModel = Students::find($studentid)->one();
				$testModel = TblTest::findOne($testid);
				$studenttests = $post['studenttests'];
				//echo json_encode(["data"=>$studentModel]); exit();
				
				$flag=false;
				$alldatamodel = [];
				$alldatamodelerros = [];
				if($studentModel && $testModel)
				{
					foreach ($studenttests as $studenttest) {
						$tqModel = TestQuestions::findOne($studenttest['questionid']);
						//echo json_encode(["data"=>$tqModel->id]); exit();
						if($tqModel)
						{
							$studenttestModel = new StudentTests();
							
							$studenttestModel->testid = $testid;
							$studenttestModel->studentid = $studentid;
							$studenttestModel->questionid = $studenttest['questionid'];
							$studenttestModel->selectedoption = null;
							$studenttestModel->correctanswer = 'unattempted';

							if(isset($studenttest['selectedoption']))
								$studenttestModel->selectedoption = $studenttest['selectedoption'];

							//if($studenttestModel->selectedoption == null )
								//$studenttestModel->correctanswer = 'unattempted';
							//else 
							if($studenttestModel->selectedoption != null )
							{
								if($tqModel->answer == $studenttest['selectedoption'])
									$studenttestModel->correctanswer = 'yes';
								else if($tqModel->answer != $studenttest['selectedoption'])
									$studenttestModel->correctanswer = 'no';
							}
							$alldatamodel[]= $studenttestModel;
							if($studenttestModel->beforeSave(true) && $studenttestModel->save())
							{
								$alldatamodel[]= $studenttestModel;
								$flag=true;
							}
							else
							{
								$flag=false;
								//return ['result'=>'fail','reason'=> 'something went wrong. Unable to save test data',"techreas"=>$studenttestModel->getErrors()];
								//break;
								$alldatamodelerros[]= $studenttestModel->getErrors();
							}


						}
						else
						{
							$flag=false;
							$alldatamodelerros[]= $studenttest['questionid'];
							//print_r("fail");exit;
							//return ['result'=>'fail','data'=>"err ".$studenttest['questionid']];
						}

					}

					/*$tqModels = TestQuestions::find(["testid" => $testid])->all();
					
					$cnt=0;
					foreach ($tqModels as $tq) {
						$studenttestModel = new StudentTests();
						$studenttest = $studenttests[$cnt++];
						
						$studenttestModel->testid = $testid;
						$studenttestModel->studentid = $studentid;
						$studenttestModel->questionid = $studenttest['questionid'];
						$studenttestModel->selectedoption = null;
						if(isset($studenttest['selectedoption']))
						$studenttestModel->selectedoption = $studenttest['selectedoption'];

						// if(isset($studenttests['selectedoption']) && $studenttests['selectedoption']!=null)
						// 	$studenttestModel->selectedoption = $studenttests['selectedoption'];
						// else if($studenttests['selectedoption'] == null)
						// 	$studenttestModel->selectedoption = null;

						
						
						
						if($tq->id == $studenttest['questionid'])
						{
							if($studenttestModel->selectedoption == null )
								$studenttestModel->correctanswer = 'unattempted';
							else if($tq->answer == $studenttest['selectedoption'])
								$studenttestModel->correctanswer = 'yes';
							else if($tq->answer != $studenttest['selectedoption'])
								$studenttestModel->correctanswer = 'no';
						}
						
						
						//$alldatamodel[]= $studenttestModel;
						
						
						if($studenttestModel->beforeSave(true) && $studenttestModel->save())
						{
							$alldatamodel[]= $studenttestModel;
						}
						else
						{
							//echo json_encode(["data"=>$studenttestModel->getErrors()]); exit();
							return ['result'=>'fail','reason'=> 'something went wrong. Unable to save test data',"techreas"=>$studenttestModel->getErrors()];
							break;
							//$alldatamodel[]['errors']= $studenttestModel->getError();
						}
					}*/
					if($flag)
						return ['result'=>'success','data'=>$alldatamodel];
					else
						return ['result'=>'fail','reason'=> 'something went wrong','tech'=>$alldatamodelerros];
				}
				else
					return ['result'=>'fail','reason'=> 'no test questions found','tech'=>$alldatamodelerros];

			}
			catch (Exception $ex) {
				throw new \yii\web\HttpException(500, 'Internal server error '.$ex->getMessage());
			}
		}
		else {
        	throw new \yii\web\HttpException(400, 'invalid request');
    	}
	}

	public function actionGetTestResultsAnalysis()
	{
		if (!empty($_POST)) {
			try {

				$testid = $_POST['testid'];
				$studentid = $_POST['studentid'];
				
				$studentModel = Students::findOne(['id'=>$studentid]);
				$testModel = TblTest::findOne(['id'=>$testid]);
				$studenttestModel = StudentTests::findAll(['studentid'=>$studentid,"testid" => $testid]);
				$alldatamodel = [];
				if($studentModel && $testModel)
				{
					//$tqModels = TestQuestions::findAll(["testid" => $testid]);
					$alldatamodel['unattempted']= [];
					$alldatamodel['correct']= [];
					$alldatamodel['incorrect']= [];
					foreach ($studenttestModel as $mod) {
						$tqmod = $mod->question;
						$m= [];
						foreach ($mod as $key => $value) {
							$m[$key] = $value;
						}
						foreach ($tqmod as $key => $value) {
							$m[$key] = $value;
						}
						
						
						if($mod->selectedoption == null )
							$alldatamodel['unattempted'][] = $m;
						else if($tqmod->answer == $mod->selectedoption)
							$alldatamodel['correct'][] = $m;
						else
							$alldatamodel['incorrect'][] = $m;

					}

					return ['result'=>'success','data'=>$alldatamodel];
				}
				else
					return ['result'=>'fail','reason'=> 'no test questions found'];

			}
			catch (Exception $ex) {
				throw new \yii\web\HttpException(500, 'Internal server error ');
			}
		}
		else {
        	throw new \yii\web\HttpException(400, 'invalid request');
    	}
	}
}
?>