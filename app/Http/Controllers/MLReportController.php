<?php
namespace App\Http\Controllers;
use App\Models\Prediction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
class MLReportController extends Controller
{
    private string $flaskUrl;
    private string $metricsPath;
    private string $chartsPath;
    private string $mlFolder;
    private string $logFile;
    public function __construct()
    {
        $this->middleware('auth');
        $this->mlFolder    = env('ML_FOLDER', '/Users/'.get_current_user().'/prodtrack-ml');
        $this->flaskUrl    = 'http://127.0.0.1:5001';
        $this->metricsPath = $this->mlFolder.'/model_metrics.json';
        $this->chartsPath  = $this->mlFolder.'/charts';
        $this->logFile     = '/tmp/prodtrack_flask.log';
    }
    public function index()
    {
        $user=$isReadOnly=Auth::user();
        $isReadOnly=in_array($user->level,[3,4,5,6]);
        $metrics=null;$metricsError=null;
        if(file_exists($this->metricsPath)){$metrics=json_decode(file_get_contents($this->metricsPath),true);}
        else{$metricsError='model_metrics.json not found. Run train_model_enhanced.py first.';}
        $charts=['model_comparison'=>['title'=>'Model Performance Comparison','file'=>'model_comparison.png'],'confusion_matrices'=>['title'=>'Confusion Matrices','file'=>'confusion_matrices.png'],'roc_curves'=>['title'=>'ROC Curves','file'=>'roc_curves.png'],'feature_importance'=>['title'=>'Feature Importance','file'=>'feature_importance.png'],'cross_validation'=>['title'=>'Cross Validation Scores','file'=>'cross_validation.png'],'precision_recall'=>['title'=>'Precision-Recall Curves','file'=>'precision_recall.png'],'baseline_vs_tuned'=>['title'=>'Baseline vs Tuned Models','file'=>'baseline_vs_tuned.png']];
        foreach($charts as $key=>$chart){$charts[$key]['exists']=file_exists($this->chartsPath.'/'.$chart['file']);$charts[$key]['route']=route('ml.chart',$key);}
        $totalPredictions=Prediction::count();
        $highRisk=Prediction::where('delay_probability','>=',0.7)->count();
        $delayed=Prediction::where('predicted_outcome','delayed')->count();
        $onTime=Prediction::where('predicted_outcome','on_time')->count();
        return view('business.ml.reports',compact('metrics','metricsError','charts','isReadOnly','totalPredictions','highRisk','delayed','onTime'));
    }
    public function serveChart($name)
    {
        $allowed=['model_comparison','confusion_matrices','roc_curves','feature_importance','cross_validation','precision_recall','baseline_vs_tuned'];
        if(!in_array($name,$allowed))abort(404);
        $path=$this->chartsPath.'/'.$name.'.png';
        if(!file_exists($path))abort(404);
        return response()->file($path,['Content-Type'=>'image/png','Cache-Control'=>'no-cache']);
    }
    public function stopFlask()
    {
        exec("lsof -ti tcp:5000 2>/dev/null",$portOutput);
        if(!empty($portOutput)){$pid=trim($portOutput[0]);exec("kill -9 {$pid} 2>/dev/null");}
        else{exec("pkill -9 -f 'app.py' 2>/dev/null");}
        return response()->json(['success'=>true,'message'=>'Stop command sent.','status'=>'stopping']);
    }
    public function getLog()
    {
        if(!file_exists($this->logFile))return response()->json(['log'=>'No log file found. Start Flask first.']);
        $lines=file($this->logFile,FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
        return response()->json(['log'=>implode("\n",array_slice($lines,-20))]);
    }
}
