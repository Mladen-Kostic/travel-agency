<template>
    <div id="travelInsurance">
        <h1 class="mb-4">Travel Insurance</h1>
        <div id="toggle" class="pt-4">
            <h4 :class="[{'textOpacity': group}, d_inline_block]">Individual Insurance</h4>

            <label class="switch mx-3">
            <input @click="this.changeOpacity" type="checkbox">
            <span class="slider round"></span>
            </label>

            <h4 :class="[{'textOpacity': individual}, d_inline_block]">Group Insurance</h4>
        </div>
        
        <form id="travelInsuranceForm" @submit.prevent="makeInsurance">
            <input v-if="group" type="hidden" name="group" value="1">
            <div class="form-group row">
                <div class="row col-6">
                    <div class="col-6">
                        <label for="departure">Departure Date</label>
                        <input name="departure" type="date" class="form-control" id="departure">
                        <div class="invalid-feedback">
                            Departure Date field is mandatory.
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="return">Return Date</label>
                        <input name="return" type="date" class="form-control" id="return">
                        <div class="invalid-feedback">
                            Return Date field is mandatory.
                        </div>
                    </div>
                </div>
                <div class="row col-6 ml-4">
                    <div class="col-6">
                        <label for="from">Travel From</label>
                        <input name="from" type="text" class="form-control" id="from">
                        <div class="invalid-feedback">
                            Travel From field is mandatory.
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="to">Travel To</label>
                        <input name="to" type="text" class="form-control" id="to">
                        <div class="invalid-feedback">
                            Travel To field is mandatory.
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-6">
                    <label for="first_name">First Name</label>
                    <input name="first_name" type="text" class="form-control" id="first_name" placeholder="First Name">
                    <div class="invalid-feedback">
                        First Name field is mandatory.
                    </div>
                </div>
                <div class="col-6">
                    <label for="last_name">Last Name</label>
                    <input name="last_name" type="text" class="form-control" id="last_name" placeholder="Last Name">
                    <div class="invalid-feedback">
                        Last Name field is mandatory.
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-6">
                    <label for="email">Email address</label>
                    <input name="email" type="text" class="form-control" id="email" placeholder="Email Address">
                    <div class="invalid-feedback">
                        Email field is mandatory.
                    </div>
                </div>
                <div class="col-6">
                    <label for="phone">Phone</label>
                    <input name="phone" type="text" class="form-control" id="phone" placeholder="Phone Number">
                    <div class="invalid-feedback">
                        Phone field is mandatory.
                    </div>
                </div>
            </div>
            
            
            
            <div class="form-group">
                <label for="last_name">Date of Birth</label>
                <input name="dob" type="date" class="form-control" id="dob">
                <div class="invalid-feedback">
                    This field is mandatory.
                </div>
            </div>
            <Transition>
            <div v-if="group">
                <GroupInsurance @addToGroupList="(obj) => groupInsuranceList.push(obj)" />

                <div v-for="item in groupInsuranceList" :key="item.id" class="form-group row">
                    <div class="col-4">{{ item.first_name }}</div>
                    <div class="col-4">{{ item.last_name }}</div>
                    <div class="col-3">{{ item.dob }}</div>
                    <div class="col-1">
                        <a @click="removeItem(item)" class="btn btn-secondary trashBtn"><i class="fas fa-trash-alt"></i></a>
                    </div>
                </div>
            </div>
            </Transition>
            <button type="submit" class="btn btn-primary">Get Insurance</button>
        </form>
        
    </div>
</template>

<script>
import GroupInsurance from './GroupInsurance.vue';
export default {

    name: 'TravelInsuranceForm',
    components: {
        GroupInsurance
    },
    data() {
        return {
            individual: true,
            group: false,
            d_inline_block: 'd-inline-block',
            groupInsuranceList: [],
            isInvalid: ''
        }
    },
    methods: {
        changeOpacity() {
            this.individual = !this.individual;
            this.group = !this.group;
        },
        removeItem(item) {
            this.groupInsuranceList = this.groupInsuranceList.filter((listItem) => listItem !== item)
        },
        isNumeric(num) {
            if (num === '' || num === null) return false;

            if (!isNaN(num) && num.length > 6) {
                return true;
            } else {
                return false;
            }
        },
        makeInsurance(e) {
            let fieldEmpty = false;
            let filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            // document.querySelectorAll('#travelInsuranceForm input').forEach(input => console.log(input.value));
            document.querySelectorAll('#travelInsuranceForm input').forEach(input => {
                if (!input.value) {
                    fieldEmpty = true;
                    input.classList.add('is-invalid');
                    input.classList.remove('is-valid');
                } else {
                    input.classList.add('is-valid');
                    input.classList.remove('is-invalid');
                }
            });

            if (!fieldEmpty) {
                let formData = {
                    group: e.target.group ? e.target.group.value : 0,
                    first_name: e.target.first_name.value,
                    last_name: e.target.last_name.value,
                    email: e.target.email.value,
                    phone: e.target.phone.value,
                    dob: e.target.dob.value,
                    departure: e.target.departure.value,
                    return: e.target.return.value,
                    from: e.target.from.value,
                    to: e.target.from.value
                };

                if (this.isNumeric(formData.phone)) {
                    console.log('phone valid');
                    document.querySelector('#phone').classList.remove('is-invalid');
                } else {
                    document.querySelector('#phone').classList.add('is-invalid');
                    document.querySelector('#phone').nextSibling.innerText = 'Phone Number should at least have 7 digits.';
                }

                if (filter.test(formData.email)) {
                    console.log('email valid');
                    document.querySelector('#email').classList.remove('is-invalid');
                } else {
                    document.querySelector('#email').classList.add('is-invalid');
                    document.querySelector('#email').nextSibling.innerText = 'This field has to be valid email.';
                }

                // axios({
                //     method: 'post',
                //     headers: {
                //         'Content-Type': 'application/json',
                //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                //     },
                //     url: '/api/travel-insurance/store',
                //     data: formData
                // })
                //     .then(res => console.log(res))
                //     .catch(error => console.log('error'));
            }

        }
    }
}
</script>

<style>
#toggle {
    border-top: 1px solid rgba(255, 255, 255, 0.295);
}

.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
  bottom: 7px
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: #fff;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

.textOpacity {
    opacity: 0.6;
}

#travelInsuranceForm {
    background-color: #1976d27c;
    padding: 2rem;
    border-radius: 2%;
}

.trashBtn {
    cursor: pointer;
    margin-left: 0.6rem;
}

.invalid-feedback {
    color: #fff!important;
}
</style>