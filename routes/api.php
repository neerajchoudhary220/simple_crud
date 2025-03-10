<?php

use Illuminate\Support\Facades\Route;

Route::controller('SportController')->prefix('sports/v1/')->group(function () {
    Route::get('test', 'test');
    Route::get('insert-country', 'insertCountry');
    /* League */
    Route::get('insert-league-data', 'insertLeagueData');
    Route::get('league', 'getLeagueData');
    /* Team */
    Route::get('insert-team-data', 'insertTeamData');
    Route::get('team', 'getTeamData');
    /* Upcoming Event */
    Route::get('insert-upcoming-data', 'insertUpcomingEventData');
    Route::get('get-upcoming-data', 'getUpcomingData');
    /* Inplay */
    Route::get('insert-inplay-data', 'insertInplayData');
    Route::get('get-inplay-data', 'getInplayData');

    /* Pre Match Market */
    Route::get('insert-pre-match-market-data', 'insertPreMatchMarketData');
    Route::get('prematch','getPreMatchMarketData');

});
