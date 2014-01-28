<?php
namespace Cerad\Bundle\GameBundle\Schedule\Import;

/* =========================================================
 * Calling it helper for lack of a better word
 * 
 * Move the assorted prepared statements to here
 * 
 * Sort of like a repo but not really
 */
class ArbiterGamesImportHelper
{
    protected $conn;
    
    public $projectSelectStatement;
    public $projectInsertStatement;
    
    public $levelSelectStatement;
    public $levelInsertStatement;
    
    public $gameSelectStatement;
    public $gameInsertStatement;
    public $gameUpdateStatement;
    
    public $gameTeamsSelectStatement;
    
    public $gameTeamInsertStatement;
    public $gameTeamHomeInsertStatement;
    public $gameTeamAwayInsertStatement;
    
    public function __construct($conn)
    {
        $this->conn = $conn;
        
        $this->prepareProjectSelect($conn);
        $this->prepareProjectInsert($conn);
        
        $this->prepareLevelSelect($conn);
        $this->prepareLevelInsert($conn);
        
        $this->prepareGameSelect($conn);
        $this->prepareGameInsert($conn);
        $this->prepareGameUpdate($conn);
        
        $this->prepareGameTeamsSelect($conn);
        
        $this->prepareGameTeamUpdate($conn);
        
        $this->prepareGameTeamHomeInsert($conn);
        $this->prepareGameTeamAwayInsert($conn);
    }
    public function commit          () { return $this->conn->commit();           }
    public function rollBack        () { return $this->conn->rollBack();         }
    public function lastInsertId    () { return $this->conn->lastInsertId();     }
    public function beginTransaction() { return $this->conn->beginTransaction(); }
    
    /* ===============================================================
     * Project Code
     */
    protected function prepareProjectSelect($conn)
    {
        $sql = <<<EOT
SELECT id FROM projects WHERE id = :key;
EOT;
        $this->projectSelectStatement = $conn->prepare($sql);
    }
    protected function prepareProjectInsert($conn)
    {
        $sql = <<<EOT
INSERT INTO projects
( id, season, sport, domain, domainSub, status)
VALUES
(:key, :season, :sport, :domain, :domainSub, 'Active')
;
EOT;
        $this->projectInsertStatement = $conn->prepare($sql);
    }
    /* ===============================================================
     * Level Code
     */
    protected function prepareLevelSelect($conn)
    {
        $sql = <<<EOT
SELECT id FROM levels WHERE id = :key;
EOT;
        $this->levelSelectStatement = $conn->prepare($sql);
    }
    protected function prepareLevelInsert($conn)
    {
        $sql = <<<EOT
INSERT INTO levels
( id, name, sport, domain, domainSub, status)
VALUES
(:key, :name, :sport, :domain, :domainSub, 'Active')
;
EOT;
        $this->levelInsertStatement = $conn->prepare($sql);
    }
    /* ==================================================
     * Game Select,Insert,Update
     * Select matches Update
     */
    protected function prepareGameSelect($conn)
    {
        $sql = <<<EOT
SELECT
    game.id        AS id,
    game.levelKey  AS levelKey,
    game.field     AS field,
    game.dtBeg     AS dtBeg,
    game.dtEnd     AS dtEnd,
    game.status    AS status
FROM  games AS game
WHERE game.projectKey = :projectKey AND game.num = :num;
EOT;
        $this->gameSelectStatement = $conn->prepare($sql);
    }
    protected function prepareGameUpdate($conn)
    {
        $sql = <<<EOT
UPDATE games SET
  field    = :field,
  levelKey = :levelKey,
  dtBeg    = :dtBeg,
  dtEnd    = :dtEnd,
  status   = :status
WHERE id = :id
;
EOT;
        $this->gameUpdateStatement = $conn->prepare($sql);
    }
    protected function prepareGameInsert($conn)
    {
        $sql = <<<EOT
INSERT INTO games
( projectKey, num, role, levelKey, field, dtBeg, dtEnd, status)
VALUES
(:projectKey,:num,'Game',:levelKey,:field,:dtBeg,:dtEnd,:status)
;
EOT;
        $this->gameInsertStatement = $conn->prepare($sql);
    }
    /* ==================================================
     * Game Teams
     */
    protected function prepareGameTeamsSelect($conn)
    {
        $sql = <<<EOT
SELECT
    gameTeam.id       AS id,
    gameTeam.slot     AS slot,
    gameTeam.role     AS role,
    gameTeam.levelKey AS levelKey,
    gameTeam.name     AS name,
    gameTeam.score    AS score
FROM  game_teams AS gameTeam
WHERE gameTeam.gameId = :gameId 
ORDER BY gameTeam.slot;
EOT;
        $this->gameTeamsSelectStatement = $conn->prepare($sql);
    }
    protected function prepareGameTeamUpdate($conn)
    {
        $sql = <<<EOT
UPDATE game_teams SET
    slot     = :slot,
    role     = :role,
    levelKey = :levelKey,
    name     = :name,
    score    = :score
WHERE id = :id
EOT;
        $this->gameTeamUpdateStatement = $conn->prepare($sql);
    }
    protected function prepareGameTeamHomeInsert($conn)
    {
        $sql = <<<EOT
INSERT INTO game_teams
( gameId, slot, role,  levelKey, name, score, status)
VALUES
(:gameId,    1,'Home',:levelKey,:name,:score,'Active')
;
EOT;
        $this->gameTeamHomeInsertStatement = $conn->prepare($sql);
    }
    protected function prepareGameTeamAwayInsert($conn)
    {
        $sql = <<<EOT
INSERT INTO game_teams
       ( gameId, slot, role,  levelKey, name, score, status)
VALUES (:gameId,    2,'Away',:levelKey,:name,:score,'Active')
;
EOT;
        $this->gameTeamAwayInsertStatement = $conn->prepare($sql);
    }
}
?>
