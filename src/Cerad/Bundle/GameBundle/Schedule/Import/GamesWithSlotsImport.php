<?php
namespace Cerad\Bundle\GameBundle\Schedule\Import;

class Results
{
    
}
class GamesWithSlotsImport
{
    protected $results;
    
    protected $sport;
    protected $domain;
    protected $season;
    protected $nums;
    
    protected function processRow($row)
    {
        // Process the game number
        $num = (integer)$row['num'];
        
        // Probably toss an exception
        if (!$num) return;
        
        // Really should not happem but does
        if (isset($this->nums[$num])) return;
        $this->nums[$num] = true;
        
        echo sprintf("Row %d %s %s %s %s\n",$num,$row['season'],$row['domain'],$row['domainSub'],$row['level']);
        
        return;
    }
    public function import($params)
    {
        // Save some
        $this->sport  = $params['sport'];
        $this->domain = $params['domain'];
        $this->season = $params['season'];
        $this->nums = array();
        
        // Setup results collector
        $this->results = $results = new Results();
        $results->basename = $params['basename'];
        $results->totalGamesCount = 0;
        
        // Must be a report file
        $reader = new \XMLReader();
        $reader->open($params['filepath'],null,LIBXML_COMPACT | LIBXML_NOWARNING);
        
       // Position to Report node
        if (!$reader->next('Report')) 
        {
            $results->message = '*** Not a Report file';
            $reader->close();
            return $results;
        }
        // Verify report type
        $reportType = $reader->getAttribute('Name');
        if ($reportType != 'Games with Slots')
        {
            $results->message = '*** Unexpected report type: ' . $reportType;
            $reader->close();
            return $results;
        }
        // Kind of screw but oh well
        while ($reader->read() && $reader->name !== 'Detail');
        
        $map = $this->map;
        
        // Loop
        while($reader->name == 'Detail')
        {
            $row = array();
            $row['sport']  = $params['sport'];
            $row['domain'] = $params['domain'];
            $row['season'] = $params['season'];
        
            foreach($this->map as $key => $attr)
            {
                $row[$key] = $reader->getAttribute($attr);
            }
            $results->totalGamesCount++;
            
            $this->processRow($row);

            // On to the next one
            $reader->next('Detail');
        }        
        // Done
        $reader->close();
        return $results;
    }
    protected $map = array
    (
        'num'           => 'GameID',
        'dtBeg'         => 'From_Date',    // 2013-03-08T16:30:00
        'dtEnd'         => 'To_Date',
        'domainSub'     => 'Sport',        // AHSAA
        'level'         => 'Level',        // MS-B
        'site'          => 'Site',
        'siteSub'       => 'Subsite',
        'homeTeamName'  => 'Home_Team',
        'homeTeamScore' => 'Home_Score',
        'awayTeamName'  => 'Away_Team',
        'awayTeamScore' => 'Away_Score',
        
        'status'        => 'Status',
        
        'officialSlots' => 'Slots_Total',
        
        'officialRole1' => 'First_Position',  // Referee 
        'officialRole2' => 'Second_Position', // AR1 (or possibly dual?
        'officialRole3' => 'Third_Position',  // AR2
        'officialRole4' => 'Fourth_Position', // 'No Fourth Position'
        'officialRole5' => 'Fifth_Position',  // 'No Fifth Position' 
        
        'officialName1' => 'First_Official', 
        'officialName2' => 'Second_Official', 
        'officialName3' => 'Third_Official', 
        'officialName4' => 'Fourth_Official',  // 'Empty'
        'officialName5' => 'Fifth_Official',   // 'Empty'
        
        'billTo'        => 'BillTo_Name',
        'billAmount'    => 'Bill_Amount',     // 100.00
        'billFees'      => 'Total_Game_Fees', //  37.00 ?
        
        'gameNote'      => 'Game_Note',    // 'No Note'
        'gameNoteDate'  => 'Note_Date=',   //  Blank
        
        'gameReportComments' => 'Game_Report_Comments',
        'gameReportDateTime' => 'Report_Posted_Date',   // 1900-01-01T00:00:00
        'gameReportStatus'   => 'Report_Status',        // 'No Report'
        'gameReportOfficial' => 'Reporting_Official',
        
    );
}
/* =====================================
 * <Detail 
 * Note_Date="" Game_Note="No Note" 
 * Fifth_Official="Empty" Fifth_Position="No Fifth Position" 
 * Fourth_Official="Empty" Fourth_Position="No Fourth Position" 
 * Third_Official="Empty" Third_Position="No Third Position" 
 * Second_Official="Empty" Second_Position="No Second Position" 
 * First_Official="Tom Lawson" First_Position="Referee" 
 * Slots_Total="1" 
 * Reporting_Official="" Report_Status="No Report" Report_Posted_Date="1900-01-01T00:00:00" 
 * Game_Report_Comments="" 
 * Status="Normal" 
 * Total_Game_Fees="25.00" Bill_Amount="25.00" BillTo_Name="HISL" 
 * Away_Score="" Away_Team="3-4_SJS-3" 
 * Home_Score="" Home_Team="3-4_Rand_Blu" 
 * Subsite="" Site="Randolph Drake Campus" 
 * Level="3rd4th" Sport="HISL" 
 * To_Date="2013-09-17T17:35:00" 
 * From_Date="2013-09-17T16:45:00" 
 * Game_LinkID="1091" 
 * GameID="2068"
 * />
 */
?>
