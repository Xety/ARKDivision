<?php
namespace Xetaravel\Models;

class LethalquestsStat extends Model
{
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'arkshop';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'SteamId',
        'Name',
        'TribeName',
        'QuestsCompleted',
        'DailyQuestsCompleted',
        'WeeklyQuestsCompleted',
        'TotalQuestsCompleted',
        'PlayerKills',
        'PlayerDeaths',
        'WildDinoKills',
        'TamedDinoKills',
        'BossKills',
        'K/D',
        'MinutesPlayed',
        'TotalDeaths',
        'PvPDamage',
        'TamedDinos',
        'RareTamedDinos',
        'RareDinoKills',
        'SuperRareDinoKills',
        'ServerEventsCompleted',
        'MissionsCompleted',
        'MissionsFailed',
        'BlueOSD',
        'YellowOSD',
        'RedOSD',
        'PurpleOSD',
        'PurpleOSDWaves',
        'ElementNodeEasy',
        'ElementNodeMedium',
        'ElementNodeHard',
        'FishCaught',
        'GoldNugget'
    ];

    /**
     * Get the user that owns the account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /*public function user()
    {
        return $this->belongsTo(User::class);
    }*/
}
