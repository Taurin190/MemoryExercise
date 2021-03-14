<template>
    <div class="">
        <div class="py-2" v-if="label_list.length">
            <label-list-component :label_list="label_list" :show_close_button="true"></label-list-component>
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
        name: "LabelSearchComponent",
        props: {
            registered_label_list : []
        },
        mounted: function() {
            for (let i = 0; i < this.registered_label_list.length; i ++) {
                this.label_list.push(this.registered_label_list[i]);
            }
        },
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
            }
        }
    }
</script>

<style scoped>

</style>
