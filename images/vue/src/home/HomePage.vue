<template>
    <div>
        <h1>Hi {{account.user.data.name}}!</h1>
        <p>You're logged to ARC testing!!</p>
        <div>
            <h3>Users from secure api end point:</h3>
            <em v-if="users.loading">Loading users...</em>
            <span v-if="users.error" class="text-danger">ERROR: {{users.error}}</span>
            <ul v-if="users.items">
                <li v-for="user in users.items" :key="user.id">
                    {{user.name}}
                    <span v-if="user.deleting"><em> - Deleting...</em></span>
                    <span v-else-if="user.deleteError" class="text-danger"> - ERROR: {{user.deleteError}}</span>
                    <span v-if="account.user.data.id !== user.id"> - <a @click="deleteUser(user.id)"
                                                                        class="text-danger">Delete</a></span>
                </li>
            </ul>
        </div>
        <hr>
        <div>
            <h3>Services</h3>
            <em v-if="users.loading">Loading services...</em>
            <span v-if="users.error" class="text-danger">ERROR: {{users.error}}</span>
            <ul v-if="services.items">
                <li v-for="service in services.items" :key="service.id">
                    {{service.service_name}} - NGN {{(service.price)}}
                    <span v-if="subscribe.loading"><em> - Subscribing...</em></span>
                    <span v-else-if="validate.loading"><em> - Validating...</em></span>
                    <span v-else-if="subscribe.error" class="text-danger"> - ERROR</span>
                    <span v-else-if="!subscriptions[service.id]"> - <a @click="serviceSub(service.id)" class="text-primary">Subscribe</a></span>
                </li>
            </ul>
        </div>
        <p>
            <router-link to="/login">Logout</router-link>
        </p>
    </div>
</template>

<script>
    import {mapState, mapActions} from 'vuex';

    export default {
        computed: {
            ...mapState({
                account: state => state.account,
                users: state => state.users.all,
                subscriptions: state => state.subscription.all,
                subscribe: state => state.subscription.sub,
                validate: state => state.subscription.validate,
                services: state => state.services.all,
            })
        },
        created() {
            this.getAllUsers();
            this.getSubscriptions();
            this.getServices();
        },
        methods: {
            ...mapActions('users', {
                getAllUsers: 'getAll',
                deleteUser: 'delete'
            }),
            ...mapActions('services', {
                getServices: 'getAll',
            }),
            ...mapActions('subscription', {
                serviceSub: 'subscribe',
                getSubscriptions: 'getAllSub',
                validateSub: 'validateSub',
            }),
            /***
             * validate subscription against payment system
             */
            callbackValidate ()  {
                let q = this.$route.query;
                if (!!q.callback && !!q.reference) {
                    this.validateSub({trxref: q.reference, service_id: q.service_id})
                        .then(() => this.$router.push('/'));
                }
            }
        },
        mounted: function () {
            this.callbackValidate();
        }
    };
</script>