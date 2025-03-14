<template>
    <div class="dropdown navbar-notifications d-inline">
        <!-- Toggle notification menu -->
        <a ref="toggle_notifications" class="dropdown-toggle" href="#" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i ref="toggle_icon_notifications" class="icon fa fa-bell-o"></i>
        </a>

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" data-bs-container="body">
            <li>
                <h6 class="dropdown-header text-center">
                    Nouvelles Notifications
                </h6>
            </li>

            <li>
                <hr class="dropdown-divider mb-0">
            </li>

            <!-- Notifications -->
            <li>
                <a v-for="notification in notifications"
                    v-on:mouseover.prevent="markNotificationAsRead(notification)"
                    :href="getNotificationUrl(notification)" :class="'notification-' + notification.id + ' dropdown-item notification-item'">

                    <!-- Image -->
                    <i v-if="notification.data.type == 'badge'" :class="notification.data.icon + ' fa-2x'" :style="'color:' + notification.data.color"></i>
                    <img v-else-if="notification.data.type == 'reward'" :src="'/' + notification.data.image" :alt="notification.data.name">
                    <img v-else src="/images/logo.svg" alt="Image">

                    <!-- Message -->
                    <span v-html="notification.data.hasOwnProperty('message_key') ? formatMessage(notification) : notification.data.message"
                        class="message"></span>

                    <!-- Badge new -->
                    <strong v-if="notification.read_at === null" :class="'notification-' + notification.id + '-new'" class="new">
                        <span></span>
                        New
                    </strong>
                </a>
            </li>

            <!-- Mark all as read -->
            <li>
                <button v-if="hasUnreadNotifs" v-on:click.prevent="markAllNotificationsAsRead" class="dropdown-item text-center">
                        Marquer toutes les notifs comme lues
                </button>
            </li>

            <li>
                <p v-if="!Array.isArray(notifications) || !notifications.length" class="dropdown-item mb-0 text-center">
                    Vous n'avez pas de notifications.
                </p>
            </li>

            <li>
                <hr class="dropdown-divider">
            </li>

            <!-- All notifications. -->
            <a :href="routeUserNotifications" class="dropdown-item text-center">
                Toutes les Notifications
            </a>
        </ul>
    </div>
</template>

<script>
    export default {
        props: {
            notifications: Array,
            unreadNotificationsCount: Number,
            hasUnreadNotifications: Boolean,
            routeUserNotifications: String,
            routeMarkNotificationAsRead: String,
            routeMarkAllNotificationsAsRead: String
        },

        data: function () {
            return {
                hasUnreadNotifs: false
            }
        },

        watch: {
            hasUnreadNotifs: function () {
                if (this.hasUnreadNotifs != this.$parent.hasUnreadNotifs) {
                    console.log('Child Notifications : triggrered');

                    this.$parent.hasUnreadNotifs = this.hasUnreadNotifs;
                }
            }
        },

        mounted() {
            this.init();

            this.$watch(() => { return this.$parent.hasUnreadNotifs },
                function (newVal, oldVal) {
                    if (this.hasUnreadNotifs != newVal) {
                        console.log('Parent Notifications : triggrered');

                        this.hasUnreadNotifs = newVal;
                    }
                }
            );
        },

        methods: {

            init: function () {
                this.hasUnreadNotifs = this.hasUnreadNotifications;
                this.$parent.hasUnreadNotifs = this.hasUnreadNotifs;
                this.$parent.unreadNotificationsCount = this.unreadNotificationsCount;
                this.$parent.routeUserNotifications = this.routeUserNotifications;
                this.$parent.routeMarkNotificationAsRead = this.routeMarkNotificationAsRead;
                this.$parent.routeMarkAllNotificationsAsRead = this.routeMarkAllNotificationsAsRead;
                this.$parent.$refs = this.$refs;
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
                    })

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
                    })
            },

            /**
             * Update the notifications counter.
             *
             * @return {void}
             */
            updateNotificationsCounter: function () {
                let notifsCount = this.notifications.reduce(function (count, notif) {
                    return count + (notif.read_at === null ? 1 : 0);
                }, 0)
                this.$parents.$refs.toggle_notifications.setAttribute("data-number", '(' + notifsCount + ')');
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
            },

            /**
             * Get the notification URL related to the notification `type`.
             *
             * @param {object} notification The current notification that is handled.
             *
             * @return {string} The notification URL.
             */
            getNotificationUrl: function (notification) {
                return this.$parent.getNotificationUrl(notification);
            }
        }
    }
</script>
