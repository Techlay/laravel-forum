<template>
    <div :id="'reply-'+id" :class="isBest ? 'card border-success' : 'card'">
        <div class="card-header">
            <div class="level">
                <div class="flex">
                    <a :href="'/profiles/' + reply.owner.name" v-text="reply.owner.name">
                    </a> said <span v-text="ago"></span>
                </div>

                <div v-if="signedIn">
                    <favorite :reply="reply"></favorite>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <form @submit="update" action="">
                    <div class="form-group">
                        <wysiwyg v-model="body"></wysiwyg>
                    </div>

                    <button class="btn btn-sm btn-primary">Update</button>
                    <button class="btn btn-sm btn-link" @click="cancel" type="button">Cancel</button>
                </form>
            </div>

            <div ref="body" v-else>
                <highlight :content="body"></highlight>
            </div>
        </div>

        <div class="card-footer level" v-if="authorize('owns', reply) || authorize('owns', reply.thread)">
            <div v-if="authorize('owns', reply)">
                <button class="btn btn-sm mr-2" @click="editing = true">Edit</button>
                <button class="btn btn-sm mr-2 btn-danger" @click="destroy">Delete</button>
            </div>

            <button class="btn btn-sm btn-outline-secondary ml-auto" @click="markBestReply"
                    v-if="authorize('owns', reply.thread)">
                Best Reply
            </button>
        </div>
    </div>
</template>

<script>
    import Favorite from './Favorite';
    import Highlight from './Highlight'
    import moment from 'moment';

    export default {
        props: ['reply'],

        components: {Favorite, Highlight},

        data() {
            return {
                editing: false,
                id: this.reply.id,
                body: this.reply.body,
                isBest: this.reply.isBest,
            }
        },

        computed: {
            ago() {
                return moment(this.reply.created_at).fromNow() + '....';
            }
        },

        created() {
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id);
            })
        },

        methods: {
            update() {
                axios.patch(
                    '/replies/' + this.id, {
                        body: this.body
                    })
                    .catch(error => {
                        flash(error.response, 'danger');
                    });

                this.editing = false;

                flash('Updated!');
            },

            cancel() {
                this.editing = false;

                this.body = this.reply.body;
            },

            destroy() {
                axios.delete('/replies/' + this.id);

                this.$emit('deleted', this.id);
            },

            markBestReply() {
                axios.post('/replies/' + this.id + '/best');

                window.events.$emit('best-reply-selected', this.id);
            }
        }
    }
</script>
