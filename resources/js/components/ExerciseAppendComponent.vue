<template>
    <div>
        <div v-for="(exercise, index) in exercise_objects" class="col-md-3 py-2 px-1 float-left">
            <div class="card workbook-card">
                <a class="text-body text-decoration-none" :href="'/exercise/' + exercise.exercise_id ">
                    <div class="card-body">
                        <h4 class="card-title">{{ exercise.question }}</h4>
                        <p class="text-break explanation">{{ exercise.answer }}</p>
                    </div>
                </a>
                <a v-if="user_id === exercise.author_id" class="text-decoration-none" :href="'/exercise/' + exercise.exercise_id + '/edit/'">
                    <div class="workbook-edit">
                        <i class="fas fa-pen"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import "axios";
    export default {
        name: "ExerciseAppendComponent",
        props: {
            count : Number,
            exercise_list: {},
            user_id: Number
        },
        data: function() {
            return {
                exercise_objects: {},
                page: 1
            }
        },
        mounted() {
            console.log($(document).innerHeight());
            console.log($(document).innerHeight() - $(window).innerHeight());
            console.log(this.exercise_list);
            document.addEventListener('scroll', this.onScroll);
            for (var i = 0; i < this.exercise_list.length; i ++) {
                this.$set(this.exercise_objects, i, this.exercise_list[i]);
            }
        },
        destroyed () {
            window.removeEventListener('scroll', this.onScroll)
        },
        methods: {
            onScroll() {
                if (this.count < 12 * this.page) return;
                let doc_height = $(document).innerHeight();
                let win_height = $(window).innerHeight();
                let bottom = doc_height - win_height;
                console.log($(window).scrollTop());
                if (bottom < $(window).scrollTop()) return;
                this.page += 1;
                axios({
                    url: '/api/exercise/list?limit=12&page=' + this.page,
                    method: 'GET'
                }).then(res =>  {
                    console.log(res);
                    for (var i = 0; i < res.data.exercise_list.length; i ++) {
                        let index = Object.keys(this.exercise_objects).length;
                        this.$set(this.exercise_objects, index, res.data.exercise_list[i]);
                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>
