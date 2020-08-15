<template>
    <div class="col-md-10 float-left">
        <div class="py-2" v-if="label_list.length">
            <div class="px-2 py-1 mr-1 mb-2 badge badge-primary" v-for="(label, index) in label_list">
                <span>{{ label }}</span>
                <input type="hidden" :value="label" />
                <a style="color: white;" href="#" @click="removeTag(index)">x</a>
            </div>
        </div>
        <p v-else class="py-2">ラベルは登録されていません。</p>
        <input class="form-control col-md-8"
               placeholder="ラベル名を入力してEnterを押して追加して下さい"
               type="text" v-model="text"
               v-on:keyup.enter="addLabel">
    </div>
</template>

<script>

    export default {
        name: "CategorySearchComponent",
        data: function() {
            return {
                text: '',
                label_list: [],
            }
        },
        methods: {
            addLabel() {
                if (this.text === '') {
                    return;
                }
                if (this.label_list.includes(this.text)) {
                    this.$swal('Warning', '"' + this.text + '"は既に登録されています。', 'OK');
                } else if(this.label_list.length > 4) {
                    this.$swal('Warning', '登録できるラベルは５つまでです。', 'OK');
                } else {
                    this.label_list.push(this.text);
                }
                this.text = '';
            },
            removeTag(index) {
                console.log(index);
                this.label_list.splice(index, 1);
            }
        },
        watch: {
            text: function() {

            }
        }
    }
</script>

<style scoped>

</style>
