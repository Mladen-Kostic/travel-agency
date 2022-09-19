<template>
    <div id="groupInsurance">
        <h4>Group Insurance</h4>
        <form @submit.prevent="addToGroupList">
            <div class="row">
                <div class="form-group col-3">
                    <label for="group_first_name">First&nbsp;Name</label>
                    <input v-model="firstName" class="form-control" id="group_first_name" placeholder="First Name">
                </div>
                <div class="form-group col-3">
                    <label for="group_last_name">Last&nbsp;Name</label>
                    <input v-model="lastName" class="form-control" id="group_last_name" placeholder="Last Name">
                </div>
                <div class="form-group col-3 groupDob">
                    <label for="group_dob">Date&nbsp;of&nbsp;Birth</label>
                    <Datepicker
                        v-model="dob"
                        placeholder="Date Of Birth"
                        :format="format"
                        id="group_dob"
                    ></Datepicker>
                </div>
                <div class="col-3 text-center">
                    <button class="btn btn-secondary addBtn btn-block"><i class="fas fa-plus-circle"></i> Add</button>
                </div>
                
            </div>
        </form>
    </div>
</template>

<script>
import { ref } from 'vue';

export default {
    setup() {
        const date = ref(new Date());

        const format = (date) => {
            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();

            return `${day}.${month}.${year}`;
        }

        return {
            date,
            format,
        }

    },
    name: 'GroupInsurance',
    emits: ['addToGroupList'],
    data() {
        return {
            firstName: '',
            lastName: '',
            dob: '',
        }
    },
    methods: {
        addToGroupList() {
            let fieldEmpty = false;

            // if (this.firstName && this.lastName && this.dob) {
            //     this.$emit('addToGroupList', {
            //         first_name: this.firstName,
            //         last_name: this.lastName,
            //         dob: this.dob
            //     });
            //     this.firstName = '';
            //     this.lastName = '';
            //     this.dob = '';
            // }

            if (this.firstName) {
                document.querySelector('#group_first_name').classList.add('is-valid');
                document.querySelector('#group_first_name').classList.remove('is-invalid');
            } else {
                fieldEmpty = true;
                document.querySelector('#group_first_name').classList.add('is-invalid');
                document.querySelector('#group_first_name').classList.remove('is-valid');
            }

            if (this.lastName) {
                document.querySelector('#group_last_name').classList.add('is-valid');
                document.querySelector('#group_last_name').classList.remove('is-invalid');
            } else {
                fieldEmpty = true;
                document.querySelector('#group_last_name').classList.add('is-invalid');
                document.querySelector('#group_last_name').classList.remove('is-valid');
            }

            if (this.dob) {
                document.querySelector('.groupDob').lastChild.firstChild.lastChild.children[0].classList.add('is-valid');
                document.querySelector('.groupDob').lastChild.firstChild.lastChild.children[0].classList.remove('is-invalid-alt');
            } else {
                fieldEmpty = true;
                document.querySelector('.groupDob').lastChild.firstChild.lastChild.children[0].classList.add('is-invalid-alt');
                document.querySelector('.groupDob').lastChild.firstChild.lastChild.children[0].classList.remove('is-valid');
            }

            if (!fieldEmpty) {
                let dateOfBirth = new Date(this.dob);
                let DD = String(dateOfBirth.getDate()).padStart(2, '0');
                let MM = String(dateOfBirth.getMonth() + 1).padStart(2, '0');
                let YYYY = dateOfBirth.getFullYear();
                dateOfBirth = YYYY + '-' + MM + '-' + DD;

                this.$emit('addToGroupList', {
                    first_name: this.firstName,
                    last_name: this.lastName,
                    dob: dateOfBirth
                });

                this.firstName = '';
                this.lastName = '';
                this.dob = '';
                
                document.querySelector('#group_first_name').classList.remove('is-valid');
                document.querySelector('#group_last_name').classList.remove('is-valid');
                document.querySelector('.groupDob').lastChild.firstChild.lastChild.children[0].classList.remove('is-valid');
            }
        }
    }
}
</script>

<style>
#groupInsurance {
    border-top: 1px solid rgba(255, 255, 255, 0.295);
}

.addBtn {
    margin-top: 1.95rem;
}

.dp__pointer.is-invalid-alt {
    border: 1px solid red;
}

.invalid-feedback-alt{
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 80%;
    color: #fff;
 }
</style>

