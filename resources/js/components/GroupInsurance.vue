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
                <div class="form-group col-3">
                    <label for="group_dob">Date&nbsp;of&nbsp;Birth</label>
                    <input v-model="dob" type="date" class="form-control" id="group_dob">
                </div>
                <div class="col-3 text-center">
                    <button class="btn btn-secondary addBtn btn-block"><i class="fas fa-plus-circle"></i> Add</button>
                </div>
                
            </div>
        </form>
    </div>
</template>

<script>
export default {
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
                document.querySelector('#group_dob').classList.add('is-valid');
                document.querySelector('#group_dob').classList.remove('is-invalid');
            } else {
                fieldEmpty = true;
                document.querySelector('#group_dob').classList.add('is-invalid');
                document.querySelector('#group_dob').classList.remove('is-valid');
            }

            if (!fieldEmpty) {
                this.$emit('addToGroupList', {
                    first_name: this.firstName,
                    last_name: this.lastName,
                    dob: this.dob
                });

                this.firstName = '';
                this.lastName = '';
                this.dob = '';
                
                document.querySelector('#group_first_name').classList.remove('is-valid');
                document.querySelector('#group_last_name').classList.remove('is-valid');
                document.querySelector('#group_dob').classList.remove('is-valid');
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
</style>

