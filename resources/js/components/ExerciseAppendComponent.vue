<template>
    <div class="col-md-3 py-2 px-1 float-left">
        <div class="card workbook-card">
            <a class="text-body text-decoration-none" href="{{route('workbook.detail', $exercise->exercise_id)}}">
                <div class="card-body">
                    <h4 class="card-title">{{ $exercise->question }}</h4>
                    <p class="text-break explanation">{!! nl2br(e($exercise->answer)) !!}</p>
                </div>
            </a>
            @if(isset($user_id) && $exercise->user->id == $user_id)
            <a class="text-decoration-none" href="{{route('exercise.edit', $exercise->exercise_id)}}">
                <div class="workbook-edit">
                    <i class="fas fa-pen"></i>
                </div>
            </a>
            @endif
        </div>
    </div>
</template>

<script>
    export default {
        name: "ExerciseAppendComponent",
        data: function() {
            return {
                exercise_list: {}
            }
        }
    }
</script>

<style scoped>

</style>
