<template>
    <div class="UsersRewards">

        <div v-if="alert.display == true" role="alert" :class="{ 'alert alert-success': !alert.error, 'alert alert-danger': alert.error}">
            <i :class="{ 'fa fa-check': !alert.error, 'fa fa-exclamation': alert.error}" aria-hidden="true"></i> {{ alert.message }}
        </diV>

        <table class="table table-hover table-rewards">

            <tr v-for="reward in rewards"
                v-on:mouseover.prevent="markRewardAsRead(reward)"
                :class="'reward-' + reward.pivot.id + ' alert reward-item'">

                <td style="position: relative;">

                    <!-- Image -->
                    <img v-if="reward.image != null" :src="'/' + reward.image" alt="Image" width="80">

                    <img v-else src="/images/logo.png" alt="Image" width="80">

                    <!-- Name -->
                    <span v-html="reward.name" class="name"></span>

                    <!-- Claim -->
                    <div v-if="reward.gender == true && reward.pivot.was_used == false" style="display: initial;">
                        <button type="button" :class="'reward-'  + reward.pivot.id + ' btn btn btn-outline-primary float-sm-right download'" data-toggle="modal" data-target="#selectGender" title="Obtenir la récompense">
                            <i class="fas fa-download" aria-hidden="true"></i>
                        </button>

                        <div class="modal fade" id="selectGender" tabindex="-1" role="dialog" aria-labelledby="selectGender" aria-hidden="true">
                            <div class="modal-dialog text-body-primary" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="selectGender">
                                            Selectionner le Genre de votre personnage
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div role="alert" class="alert alert-danger">
                                                <i aria-hidden="true" class="fa fa-exclamation"></i> Un skin <i>Homme</i> <b>ne peut pas</b> s'équiper sur un personnage <i>Femme</i> et inversement !
                                            </div>
                                            <p>
                                                Ce skin requiert que vous <b>sélectionniez le Genre de votre personnage</b> ingame.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="modal-actions">
                                        <button type="button" class="ma ma-btn ma-btn-femme" data-dismiss="modal" v-on:click.prevent="claimReward(reward, 'female')">
                                            Femme
                                        </button>
                                        <button type="button" class="ma ma-btn ma-btn-homme" data-dismiss="modal" v-on:click.prevent="claimReward(reward, 'male')">
                                            Homme
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else style="display: initial;">
                        <button v-if="reward.pivot.was_used == false" v-on:click.prevent="claimReward(reward)" type="button" :class="'reward-'  + reward.pivot.id + '-button btn btn btn-outline-primary float-sm-right download'" data-toggle="tooltip" title="Obtenir la récompense">
                            <i class="fas fa-download" aria-hidden="true"></i>
                        </button>
                    </div>



                    <!-- Description -->
                   <div v-html="reward.description" class="description"></div>

                    <!-- Date -->
                   <p class="text-muted date">
                       <small>Obtenu le {{reward.pivot.created_at | formatDate}}</small><small v-if="reward.pivot.used_at !== null"> | Claim le {{reward.pivot.used_at | formatDate}}</small>
                    </p>

                    <!-- Badge new -->
                    <strong v-if="reward.pivot.read_at === null" :class="'reward-' + reward.pivot.id + '-new'" class="new">
                        <span></span>
                        New
                    </strong>
                </td>
            </tr>

        </table>
    </div>
</template>

<script>
    export default {
        props: {
            rewards: Array,
            routeClaimReward: String,
            routeRewardMarkAsRead: String
        },

        data: function() {
            return {
                alert: {
                    message: '',
                    error: false,
                    display: false
                }
            }
        },

        methods: {

            /**
             * Claim a reward.
             *
             * @param {object} reward The reward to claim.
             * @param {string|bool} gender The gender of the claim if there's one.
             *
             * @return {void}
             */
            claimReward: function (reward, gender = false) {
                let _this = this;

                axios
                    .post(this.routeClaimReward, {
                        id: reward.pivot.id,
                        gender: gender
                    })
                    .then(function(response) {
                        if (response.data.error == false) {
                            _this.removeClaimButton(reward);
                        }
                        _this.alert = response.data;

                        setTimeout(() => _this.alert.display = false, 10000);
                    })
                    .catch(function (error) {
                        console.log('Error while claiming the reward. ' + error);
                    });
            },

            /**
         * Remove the claim button for the reward.
         *
         * @param {object} reward The reward where to remove the claim button.
         *
         * @return {void}
         */
        removeClaimButton: function (reward) {
            let buttons = document.getElementsByClassName('reward-' + reward.pivot.id + '-button');

            Array.from(buttons).forEach((button) => {
                button.parentNode.removeChild(button);
            });
        },

            /**
             * Mark a reward as read.
             *
             * @param {object} reward The current reward to mark has read.
             *
             * @return {true|void} When the reward is already read.
             */
            markRewardAsRead: function (reward) {
                let _this = this;

                // Prevent for sending unnecessary AJAX requests.
                if (reward.pivot.read_at !== null) {
                    return true;
                }

                axios
                    .post(this.routeRewardMarkAsRead, {
                        id: reward.pivot.id
                    })
                    .then(function(response) {
                        if (response.data.error == false) {
                            _this.removeNewBadge(reward);
                        }
                    })
                    .catch(function (error) {
                        console.log('Error while making the reward as read. ' + error);
                    });
            },

            /**
             * Remove the `new` badge on the reward.
             *
             * @param {object} reward The reward where the `new` badge must be removed.
             *
             * @return {void}
             */
            removeNewBadge: function (reward) {
                let badges = document.getElementsByClassName('reward-' + reward.pivot.id + '-new');

                Array.from(badges).forEach((badge) => {
                    badge.parentNode.removeChild(badge);
                });

                reward.pivot.read_at = new Date();
            },
        }
    }
</script>
