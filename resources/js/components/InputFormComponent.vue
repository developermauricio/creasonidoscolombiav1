<template>

    <div :class="'form-group '+clases">
        <label v-if="showLabel" class="form-control-label" :for="id">
            <span  v-text="label"></span>

            <span class="text-danger asterisco" v-if="required">*</span>
            <slot name="toltip"></slot>
        </label>
        <datepicker
            v-if="type === 'date'"
            :language="language === 'es' ? es : en"
            :input-class="'form-control '+((!validated||msgServer) ? 'is-invalid': '')"
            placeholder="formato 1998-06-06"
            :class="((!validated||msgServer) ? 'is-invalid': '')"
            :full-month-name="true"
            format="yyyy-MM-dd"
            :value="modelo"
            :typeable="true"
            v-bind="datepicker"
            v-on="inputListeners"
            @selected="change($event, true)"
        ></datepicker>
        <textarea
            v-else-if="type === 'textarea'"
            class="form-control"
            :class="(!validated||msgServer) ? 'is-invalid': ''"
            :id="id"
            :placeholder="label"
            :value="modelo"
            :required="required"
            v-on:input="change($event.target.value)"
            v-bind="options"
            @change="cambio"
        ></textarea>
        <multiselect
            v-else-if="type === 'multiselect'"
            :class="(!validated||msgServer) ? 'is-invalid': ''"
            :id="id"
            :label="label"
            :required="required"
            v-bind="multiselect"
            :value="modelo"
            @input="change($event)"
        ></multiselect>
        <money
            v-else-if="type === 'money'"
            v-on:input="change($event)"
            v-bind:value="modelo"
            v-bind="money"
            class="form-control"
            :class="(!validated||msgServer) ? 'is-invalid': ''"
        ></money>
        <ckeditor
            v-else-if="type === 'ckeditor'"
            @input="onEditorInput"
            v-bind="options"
            :class="(!validated||msgServer) ? 'is-invalid': ''"
        ></ckeditor>
        <input
            :type="tipoInput"
            class="form-control"
            :class="(!validated||msgServer) ? 'is-invalid': ''"
            :id="id"
            :placeholder="label"
            :required="required"
            :value="modelo"
            v-on:input="change($event.target.value)"
            @blur="changeFocus"
            @change="cambio"
            v-bind="options"
            v-on="inputListeners"
            v-else
            :disabled="disabled == 1"
        />
        <div
            class="invalid-feedback"
            v-if="!validated || msgServer"
        >{{ msgServer ? msgServer[0] : ( (!validated&&noValue) ? requiredMsg : errorMsg )}}</div>
    </div>
</template>
<script>
import { en, es } from "vuejs-datepicker/dist/locale";
import Datepicker from "vuejs-datepicker";
import Multiselect from "vue-multiselect";

export default {
    data: function() {
        return {
            validator: null,
            validated: true,
            valorActual: null,
            tipoInput: "text",
            es: es,
            en: en,
            language: window.lang,
            noValue: true
        };
    },
    props: {
        disabled:Number,
        label: String,
        id: String,
        pattern: String,
        errorMsg: String,
        requiredMsg: String,
        required: Boolean,
        modelo: [String, Number, Date, Object, Array],
        clases: String,
        msgServer: Array,
        type: String,
        datepicker: {
            type: Object,
            default: function() {
                return {};
            }
        },
        money: {
            type: Object,
            default: function() {
                return {};
            }
        },
        multiselect: {
            type: Object,
            default: function() {
                return {};
            }
        },
        options: {
            type: Object,
            default: function() {
                return {};
            }
        },
        showLabel: {
            type: Boolean,
            default: true
        },
        customValid: {
            type: Function
        }
    },
    components: {
        Datepicker,
        Multiselect
    },
    computed: {
        inputListeners: function() {
            var vm = this;
            return Object.assign({}, this.$listeners);
        }
    },
    mounted() {
        if (this.type) {
            this.tipoInput = this.type;
        }
        eventBus.$on("validarFormulario", () => {
            this.changeFocus();
        });

        switch (this.pattern) {
            case "num":
                this.validator = /^[0-9 ]+$/iu;
                break;
            case "alf":
                this.validator = /^[a-z á-ú ü à-ù]+$/iu;
                break;
            case "alf_num":
                this.validator = /^[a-z á-ú ü 0-9 à-ù]+$/iu;
                break;
            case "email":
                this.validator = RegExp(
                    "^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$"
                );
                break;
            case "all":
                this.validator = RegExp(".+");
                break;
            case "url":
                this.validator = /^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]+$/;
                break;
            case "datemdy":
                this.validator = /^([0-2][0-9]|(3)[0-1])(.)(((0)[0-9])|((1)[0-2]))(.)\d{4}$/;
                break;
            case "dateymd":
                this.validator = /^\d{4}(.)(((0)[0-9])|((1)[0-2]))(.)([0-2][0-9]|(3)[0-1])$/;
                break;
            default:
                this.validator = RegExp(this.pattern);
        }
    },
    methods: {
        change(val) {
            this.validate(val, true);
        },
        changeFocus() {
            this.validate();
        },
        validate(value = null, change = false) {
            if (change) {
                if (value !== this.valorActual){
                    this.$emit("update:modelo", value);
                    this.$emit("updatedValue", value);
                } else {
                    return;
                }
                this.valorActual = value;
            } else if (this.modelo) {
                this.valorActual = this.modelo;
            }

            if (this.type === "date") {
                this.validated = this.required
                    ? !this.isEmpty(this.valorActual)
                    : true;
            } else if (this.customValid) {
                this.validated = this.customValid(this.valorActual);
            } else if (typeof value !== "string") {
                this.validRequired(this.valorActual);
            } else if (value === "$ 0") {
                this.noValue = true;
                this.validated = !this.required;
            } else {
                if (this.validator) {
                    this.validated = this.validator.test(this.valorActual);
                }
                this.validRequired(this.valorActual);
            }
        },
        validRequired(val) {
            this.noValue = false;
            this.isEmpty(val);
            if (this.noValue) {
                this.validated = !this.required;
            }
        },
        isEmpty(value) {
            if (!value) {
                this.noValue = true;
                return true;
            }
            const type = typeof value;
            switch (type) {
                case "string":
                    this.noValue =
                        value === "$ 0" ? true : value.trim().length < 1;
                    break;
                case "object":
                    if (Array.isArray(value)) {
                        this.noValue = value.length < 1;
                        this.validated = this.required ? !this.noValue : true;
                    } else {
                        this.noValue = !value;
                        this.validated = this.required ? !this.noValue : true;
                    }
                    break;
                case "number":
                    this.noValue = false;
                    this.validated = true;
                    break;
                default:
                    this.noValue = true;
                    break;
            }
            return this.noValue;
        },
        cambio() {
            this.$emit("update:msgServer", null);
            this.$emit("update:modelo", this.valorActual);
            this.validate();
        },
        onEditorInput(event) {
            this.validate(event, true);
        },
        formatDate(date) {
            if (!date) {
                return "";
            }
            return moment(date).format("YYYY-MM-DD HH:mm");
        }
    }
};
</script>
