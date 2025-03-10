<template>
    <div class="UsersNotifications">

        <!-- Mark all as read -->
        <button v-if="hasUnreadNotifs" v-on:click.prevent="markAllNotificationsAsRead" class="btn btn-sm btn-outline-primary mark-all-notifications-as-read text-xs-center">
                <i class="fa fa-check" aria-hidden="true"></i> Marquer toutes les notifs comme lues
        </button>

        <ul class="list-group">

            <li v-for="notification in notifications"
                v-on:mouseover.prevent="markNotificationAsRead(notification)"
                :class="'notification-' + notification.id + ' list-group-item'" style="border-bottom: 1px solid rgba(68, 60, 50, 0.3);">
                <div class="row">

                    <div  :class="homepage ? 'col-12 d-flex align-items-center' : 'col-10 d-flex align-items-center'">
                        <!-- Image -->
                        <i v-if="notification.data.type == 'badge'" :class="notification.data.icon + ' fa-2x me-3'" :style="'color:' + notification.data.color"></i>

                        <img v-else-if="notification.data.type == 'reward'" :src="'/' + notification.data.image" :alt="notification.data.name" width="50px" height="50px">

                        <img v-else src="/images/logo.svg" alt="Image" width="60">

                        <!-- Message -->
                        <span v-html="notification.data.hasOwnProperty('message_key') ? formatMessage(notification) : notification.data.message" class="message"></span>

                        <!-- Badge new -->
                        <strong v-if="notification.read_at === null" :class="'notification-' + notification.id + '-new'" class="new">
                            <span></span>
                            New
                        </strong>
                    </div>

                    <div v-if="homepage == false" class="col-2 text-end">
                        <!-- Delete -->
                        <a v-on:click.prevent="deleteNotification(notification)" type="button" class="close text-white" data-bs-toggle="tooltip" style="font-size: xxx-large;" title="Supprimer cette notification" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>

                </div>
            </li>

        </ul>
    </div>
</template>

<script>
    export default {
        props: {
            notifications: Array,
            routeDeleteNotification: String,
            homepage: Boolean
        },

        data: function () {
            return {
                hasUnreadNotifs: false
            }
        },

        mounted() {
            this.hasUnreadNotifs = this.$parent.hasUnreadNotifs;

            this.$watch(() => { return this.$parent.hasUnreadNotifs },
                function (newVal, oldVal) {
                    if (this.hasUnreadNotifs != newVal) {
                        console.log('Parent UsersNotifications : triggrered');

                        this.hasUnreadNotifs = newVal;
                    }
                }
            );
        },

        watch: {
            hasUnreadNotifs: function () {
                if (this.hasUnreadNotifs != this.$parent.hasUnreadNotifs) {
                    this.$parent.hasUnreadNotifs = this.hasUnreadNotifs;
                }
            }
        },

        methods: {

            /**
             * Delete a notification.
             *
             * @param {object} notification The notification to delete.
             *
             * @return {void}
             */
            deleteNotification: function (notification) {
                let _this = this;

                axios
                    .delete(this.routeDeleteNotification + '/' + notification.id)
                    .then(function(response) {
                        if (!response.error) {
                            _this.$parent.removeNotification(notification);
                        }
                    })
                    .catch(function (error) {
                        console.log('Error while deleting the notification. ' + error);
                    });
            },

            /**
             * Mark all notifications as read.
             *
             * @return {void}
             */
            markAllNotificationsAsRead: function () {
                let _this = this;

                axios
                    .post(this.$parent.routeMarkAllNotificationsAsRead)
                    .then(function(response) {
                        if (!response.error) {
                            _this.notifications.forEach(function(notification) {
                                if (notification.read_at === null) {
                                    _this.$parent.removeNewBadge(notification);
                                }
                            });
                        }
                    })
                    .catch(function (error) {
                        console.log('Error while making all notifications as read. ' + error);
                    });

                this.hasUnreadNotifs = false;
                this.$parent.updateBell();
            },

            /**
             * Mark a notification as read.
             *
             * @param {object} notification The current notification to mark has read.
             *
             * @return {true|void} When the notification is already read.
             */
            markNotificationAsRead: function (notification) {
                let _this = this;

                // Prevent for sending unnecessary AJAX requests.
                if (notification.read_at !== null) {
                    return true;
                }

                axios
                    .post(this.$parent.routeMarkNotificationAsRead, {
                        id: notification.id
                    })
                    .then(function(response) {
                        if (!response.error) {
                            _this.$parent.removeNewBadge(notification);

                            let hasStillNewNotifs = _this.notifications.find(function (notif) {
                                return notif.read_at === null;
                            });

                            if (typeof hasStillNewNotifs == 'undefined') {
                                _this.$parent.updateBell();
                                _this.hasUnreadNotifs = false;
                            } else {
                                _this.updateNotificationsCounter();
                            }
                        }
                    })
                    .catch(function (error) {
                        console.log('Error while making the notification as read. ' + error);
                    });
            },

            /**
             * Update the notifications counter.
             *
             * @return {void}
             */
            updateNotificationsCounter: function () {
                let notifsCount = this.notifications.reduce(function (count, notif) {
                    return count + (notif.read_at === null ? 1 : 0);
                }, 0);
                this.$parent.$refs.toggle_notifications.setAttribute("data-number", '(' + notifsCount + ')');
            },

            /**
             * Format the message with vsprintf before rendering.
             *
             * @param {object} notification The current notification that is handled.
             *
             * @return {string} The parsed message.
             */
            formatMessage: function (notification) {
                return this.$parent.formatMessage(notification);
            }
        }
    }
</script>
