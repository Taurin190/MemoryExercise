<template>
    <div>
        <div v-for="(exercise, index) in exercise_list" class="col-md-3 py-2 px-1 float-left">
            <div class="card workbook-card">
                <a class="text-body text-decoration-none" :href="'/exercise/' + exercise.exercise_id ">
                    <div class="card-body">
                        <h4 class="card-title">{{ exercise.question }}</h4>
                        <p class="text-break explanation">{{ exercise.answer }}</p>
                    </div>
                </a>
                <!--@if(isset($user_id) && exercise.user.id == $user_id)-->
                <a class="text-decoration-none" :href="'/exercise/' + exercise.exercise_id + '/edit/'">
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
            exercise_list: {}
        },
        data: function() {
            return {
                // exercise_list: {},
                page: 1
            }
        },
        mounted() {
            console.log($(document).innerHeight());
            console.log($(document).innerHeight() - $(window).innerHeight());
            document.addEventListener('scroll', this.onScroll);
        },
        // created () {
        //     window.addEventListener('scroll', this.onScroll)
        // },
        destroyed () {
            window.removeEventListener('scroll', this.onScroll)
        },
        methods: {
            onScroll() {
                if (this.count < 12 * this.page) return;
                let doc_height = $(document).innerHeight();
                let win_height = $(window).innerHeight();
                let bottom = doc_height - win_height;
                // console.log(bottom * 0.8);
                console.log($(window).scrollTop());
                if (bottom * 0.8 < $(window).scrollTop()) return;
                this.page += 1;
                axios({
                    url: '/api/exercise/list?page=' + this.page,
                    method: 'GET'
                }).then(res =>  {
                    console.log(res);
                    for (var i = 0; i < res.data.exercise_list.length; i ++) {
                        let index = this.exercise_list.length;
                        this.$set(this.exercise_list, index, res.data.exercise_list[i]);
                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>
