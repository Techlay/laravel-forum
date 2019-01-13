/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Flash from "./components/Flash";
import Paginator from "./components/Paginator";
import UserNotifications from "./components/UserNotifications";
import AvatarForm from "./components/AvatarForm";
import Activities from "./components/Activities";
import ActivityLayout from "./components/ActivityLayout";
import ActivityFavorite from "./components/ActivityFavorite";
import ActivityReply from "./components/ActivityReply";
import ActivityThread from "./components/ActivityThread";
import Wysiwyg from "./components/Wysiwyg";
import Dropdown from "./components/Dropdown";
import ChannelDropdown from "./components/ChannelDropdown";
import LogoutButton from "./components/LogoutButton";
import Login from "./components/Login";
import Register from "./components/Register";
import Highlight from "./components/Highlight";

import Thread from "./pages/Thread";

Vue.component("flash", Flash);
Vue.component("paginator", Paginator);
Vue.component("user-notifications", UserNotifications);
Vue.component("avatar-form", AvatarForm);
Vue.component("activities", Activities);
Vue.component("activity-layout", ActivityLayout);
Vue.component("activity-favorite", ActivityFavorite);
Vue.component("activity-reply", ActivityReply);
Vue.component("activity-thread", ActivityThread);
Vue.component("wysiwyg", Wysiwyg);
Vue.component("dropdown", Dropdown);
Vue.component("channel-dropdown", ChannelDropdown);
Vue.component("logout-button", LogoutButton);
Vue.component("login", Login);
Vue.component("register", Register);
Vue.component("highlight", Highlight);

Vue.component("thread-view", Thread);

const app = new Vue({
    el: "#app",

    data: {
        searching: false
    },

    methods: {
        search() {
            this.searching = true;

            this.$nextTick(() => {
                this.$refs.search.focus();
            });
        }
    }
});
