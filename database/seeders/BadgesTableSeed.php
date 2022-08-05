<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BadgesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $badges = [
            // Leaderboard
            [
                'name' => 'Pilier de la Communauté',
                'slug' => 'topleaderboard',
                'description' => 'Débloqué quand vos points d\'expériences sont dans le top 3 de tout les membres Division.',
                'icon' => 'fas fa-medal',
                'color' => '#f7a925',
                'type' => 'topLeaderboard',
                'rule' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // Inscription
            [
                'name' => 'Inscrit depuis 1 an !',
                'slug' => 'newregister1',
                'description' => 'Gagné lorsque vous êtes inscrit sur Division depuis 1 an.',
                'icon' => 'fas fa-sign-in-alt',
                'color' => '#2ec5ff',
                'type' => 'onNewRegister',
                'rule' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Jeune adolescent !',
                'slug' => 'newregister2',
                'description' => 'Gagné lorsque vous êtes inscrit sur Division depuis 2 ans.',
                'icon' => 'fas fa-sign-in-alt',
                'color' => '#2eff51',
                'type' => 'onNewRegister',
                'rule' => 2,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Tu deviens vieux !',
                'slug' => 'newregister3',
                'description' => 'Gagné lorsque vous êtes inscrit sur Division depuis 3 ans.',
                'icon' => 'fas fa-sign-in-alt',
                'color' => '#dfff2e',
                'type' => 'onNewRegister',
                'rule' => 3,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Club du 3ième âge !',
                'slug' => 'newregister5',
                'description' => 'Gagné lorsque vous êtes inscrit sur Division depuis 5 ans.',
                'icon' => 'fas fa-sign-in-alt',
                'color' => '#ffbf2e',
                'type' => 'onNewRegister',
                'rule' => 5,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'C\'est la maison de retraite !',
                'slug' => 'newregister7',
                'description' => 'Gagné lorsque vous êtes inscrit sur Division depuis 7 ans.',
                'icon' => 'fas fa-sign-in-alt',
                'color' => '#ff412e',
                'type' => 'onNewRegister',
                'rule' => 7,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // Posts
            [
                'name' => 'Bienvenue dans la Communauté !',
                'slug' => 'newpost1',
                'description' => 'Obtenu après votre premier message sur le discuss de Division.',
                'icon' => 'far fa-comment-dots',
                'color' => '#2ec5ff',
                'type' => 'onNewPost',
                'rule' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Bavardeur !',
                'slug' => 'newpost10',
                'description' => 'Obtenu une fois que vous avez posté 10 réponses sur le discuss.',
                'icon' => 'far fa-comment-dots',
                'color' => '#2effcf',
                'type' => 'onNewPost',
                'rule' => 10,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Une vraie pipelette !',
                'slug' => 'newpost50',
                'description' => 'Obtenu une fois que vous avez posté 50 réponses sur le discuss.',
                'icon' => 'far fa-comment-dots',
                'color' => '#2eff51',
                'type' => 'onNewPost',
                'rule' => 50,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Tu arrêtes pas de jacter !',
                'slug' => 'newpost100',
                'description' => 'Obtenu une fois que vous avez posté 100 réponses sur le discuss.',
                'icon' => 'far fa-comment-dots',
                'color' => '#dfff2e',
                'type' => 'onNewPost',
                'rule' => 100,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Un vrai spammeur !',
                'slug' => 'newpost500',
                'description' => 'Obtenu une fois que vous avez posté 500 réponses sur le discuss.',
                'icon' => 'far fa-comment-dots',
                'color' => '#ffbf2e',
                'type' => 'onNewPost',
                'rule' => 500,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Pire que Yaya !',
                'slug' => 'newpost1000',
                'description' => 'Obtenu une fois que vous avez posté 1000 réponses sur le discuss.',
                'icon' => 'far fa-comment-dots',
                'color' => '#ff412e',
                'type' => 'onNewPost',
                'rule' => 1000,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // Posts Résolus
            [
                'name' => 'Vous avez aidé un membre !',
                'slug' => 'postsolved1',
                'description' => 'Obtenu une fois que vous avez reçu votre première « Réponse Résolue » sur le discuss de Division.',
                'icon' => 'fas fa-check',
                'color' => '#2ec5ff',
                'type' => 'onPostSolved',
                'rule' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'T\'es vraiment intelligent !',
                'slug' => 'postsolved10',
                'description' => 'Obtenu une fois que vous avez reçu 10 ou plus « Réponse Résolue » sur le discuss.',
                'icon' => 'fas fa-check',
                'color' => '#2eff51',
                'type' => 'onPostSolved',
                'rule' => 10,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Un vrai tuteur !',
                'slug' => 'postsolved20',
                'description' => 'Obtenu une fois que vous avez reçu 20 ou plus « Réponse Résolue » sur le discuss.',
                'icon' => 'fas fa-check',
                'color' => '#dfff2e',
                'type' => 'onPostSolved',
                'rule' => 20,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Une encyclopédie !',
                'slug' => 'postsolved50',
                'description' => 'Obtenu une fois que vous avez reçu 50 ou plus « Réponse Résolue » sur le discuss.',
                'icon' => 'fas fa-check',
                'color' => '#ff412e',
                'type' => 'onPostSolved',
                'rule' => 50,
                'created_at' => $now,
                'updated_at' => $now
            ],

            //  Donations
            [
                'name' => 'Première donation !',
                'slug' => 'newdonation1',
                'description' => 'Gagné lors de votre première donation à Division.',
                'icon' => 'fas fa-gift',
                'color' => '#2ec5ff',
                'type' => 'onNewDonation',
                'rule' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '5 donations déjà !',
                'slug' => 'newdonation5',
                'description' => 'Gagné lorsque vous avez fait au moins 5 donations.',
                'icon' => 'fas fa-gift',
                'color' => '#2eff51',
                'type' => 'onNewDonation',
                'rule' => 5,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Donateur hors pair !',
                'slug' => 'newdonation10',
                'description' => 'Gagné lorsque vous avez fait au moins 10 donations.',
                'icon' => 'fas fa-gift',
                'color' => '#dfff2e',
                'type' => 'onNewDonation',
                'rule' => 10,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Bill Gates !',
                'slug' => 'newdonation20',
                'description' => 'Gagné lorsque vous avez fait 20 donations.',
                'icon' => 'fas fa-gift',
                'color' => '#ff412e',
                'type' => 'onNewDonation',
                'rule' => 20,
                'created_at' => $now,
                'updated_at' => $now
            ],

            //  Expériences
            [
                'name' => 'La première centaine !',
                'slug' => 'newexperience100',
                'description' => 'Obtenu une fois que vous avez gagné vos 100 premiers points d\'expérience.',
                'icon' => 'fas fa-star',
                'color' => '#2ec5ff',
                'type' => 'onNewExperience',
                'rule' => 100,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Le premier millier !',
                'slug' => 'newexperience1000',
                'description' => 'Obtenu une fois que vos points d\'expérience atteignent 1000.',
                'icon' => 'fas fa-star',
                'color' => '#2eff51',
                'type' => 'onNewExperience',
                'rule' => 1000,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Un vrai soldat !',
                'slug' => 'newexperience10000',
                'description' => 'Obtenu une fois que vos points d\'expérience atteignent 10,000.',
                'icon' => 'fas fa-star',
                'color' => '#dfff2e',
                'type' => 'onNewExperience',
                'rule' => 10000,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Un vétéran de Division !',
                'slug' => 'newexperience100000',
                'description' => 'Obtenu une fois que vos points d\'expérience atteignent 100,000.',
                'icon' => 'fas fa-star',
                'color' => '#ffbf2e',
                'type' => 'onNewExperience',
                'rule' => 100000,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Le million !',
                'slug' => 'newexperience1000000',
                'description' => 'Gagnez une fois que vos points d\'expérience dépassent le million.',
                'icon' => 'fas fa-star',
                'color' => '#ff412e',
                'type' => 'onNewExperience',
                'rule' => 1000000,
                'created_at' => $now,
                'updated_at' => $now
            ],

            //  Rubies
            [
                'name' => 'Ca brille !',
                'slug' => 'newrubies50',
                'description' => 'Obtenu une fois que vous avez gagné vos 50 premiers rubies.',
                'icon' => 'fa fa-diamond',
                'color' => '#2ec5ff',
                'type' => 'onNewRuby',
                'rule' => 50,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Comme s\'il en pleuvait !',
                'slug' => 'newrubies100',
                'description' => 'Obtenu une fois que vos rubies atteignent 100.',
                'icon' => 'fa fa-diamond',
                'color' => '#2eff51',
                'type' => 'onNewRuby',
                'rule' => 100,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Un vrai mineur !',
                'slug' => 'newrubies500',
                'description' => 'Obtenu une fois que vos rubies atteignent 500.',
                'icon' => 'fa fa-diamond',
                'color' => '#dfff2e',
                'type' => 'onNewRuby',
                'rule' => 500,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Un vrai bijoutier !',
                'slug' => 'newrubies1000',
                'description' => 'Obtenu une fois que vos rubies atteignent 1000.',
                'icon' => 'fa fa-diamond',
                'color' => '#ff412e',
                'type' => 'onNewRuby',
                'rule' => 1000,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Disciple de Nakor',
                'slug' => 'eventnakor',
                'description' => 'Obtenu lors de la participation à l\'évènement L\'épopée de Nakor le 28/02/2021',
                'icon' => 'fa fa-dragon',
                'color' => '#e67e22',
                'type' => 'eventParticipating',
                'rule' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ];

        DB::table('badges')->insert($badges);
    }
}
