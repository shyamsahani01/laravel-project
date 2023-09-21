const EMPLOYEE_EDUCATION_TABLE_FIELDNAME = "employee_education"
const TEL_FIELDS = ["current_mobile_no", "permanent_mobile_no"]
const TEL_PATTERN = /^[6-9]\d{9}$/
const JOB_DETAILS_FETCH_URL = `https://reports.pinkcityindia.com/api/webapi/get-job-opening-details?job_title=`;
const JOB_DETAIL_FIELDS = ["kra", "salary_lower_range", "salary_upper_range"]

const EMP_EDU_TABLE_DATA = [{
    "name": "10th"
}, {
    "name": "12th"
}, {
    "name": "Graduate"
}, {
    "name": "Master Degree"
}, ]

frappe.web_form.after_load = () => {
    filterJobOpening();
    setup();
};

frappe.web_form.on("job_title", (field, value) => {
    console.log(field, " = ", value)
    var url = JOB_DETAILS_FETCH_URL + window.encodeURI(value.trim());
    // var url = JOB_DETAILS_FETCH_URL + value.trim();
    if (!value) {
        $.map(JOB_DETAIL_FIELDS, jdf => {
            frappe.web_form.fields_dict[jdf].df.hidden = 1
        })
        frappe.web_form.refresh()
    } else {
        fetch(url, {
                method: 'GET',
            })
            .then(r => r.json())
            .then(r => {
                console.log(r);
                var data = r.data;
                var kra_details = data.kra_details;
                var salary_lower_range = data.lower_range;
                var salary_upper_range = data.upper_range;

                frappe.web_form.set_value("kra", kra_details)
                frappe.web_form.set_value("salary_lower_range", salary_lower_range)
                frappe.web_form.set_value("salary_upper_range", salary_upper_range)

                // frappe.web_form.fields_dict.kra.df.hidden = 0
                // frappe.web_form.fields_dict.salary_lower_range.df.hidden = 0
                // frappe.web_form.fields_dict.salary_upper_range.df.hidden = 0
                $.map(JOB_DETAIL_FIELDS, jdf => {
                    frappe.web_form.fields_dict[jdf].df.hidden = 0
                })
                frappe.web_form.refresh()
            })
    }
})

frappe.web_form.on("current_address", (field, value) => {
    var samm = frappe.web_form.doc.same_as_ca;
    if (samm) {
        frappe.web_form.doc.permanent_address = value;
        frappe.web_form.refresh()
    }
})

frappe.web_form.on("current_mobile_no", (field, value) => {
    var samm = frappe.web_form.doc.same_as_ca;
    if (samm) {
        frappe.web_form.doc.permanent_mobile_no = value;
        frappe.web_form.refresh()
    }
})

frappe.web_form.on("same_as_ca", (field, value) => {
    var value = (value == undefined) ? 1 : 0

    if (value) {
        frappe.web_form.doc.permanent_address = frappe.web_form.doc.current_address;
        frappe.web_form.doc.permanent_mobile_no = frappe.web_form.doc.current_mobile_no
    } else {
        frappe.web_form.doc.current_address = ""
        frappe.web_form.doc.permanent_mobile_no = ""
    }
    frappe.web_form.refresh()
})


function filterJobOpening() {
    var api_url = 'https://reports.pinkcityindia.com/api/webapi/get-job-opening';
    $.ajax({
        type: 'GET',
        url: api_url,
        success: function (result) {

            result = JSON.parse(result);

            var options = [];
            try {
                $.map(result.data, (item) => {
                    options.push({
                        'label': item.job_title,
                        'value': item.name
                    });
                })
            } catch (err) {

            }
            var field = frappe.web_form.get_field("job_title");
            field._data = options;
            field.refresh();
        }
    });
};

function setup() {
    var ee = frappe.web_form.get_field("employee_education");
    ee.grid.fields_map.name.hidden = true
    frappe.web_form.refresh()

    var ewh = frappe.web_form.get_field("work_history");
    ewh.grid.fields_map.name.hidden = true

    $.map(EMP_EDU_TABLE_DATA, (item, index) => {
        frappe.web_form.fields_dict[EMPLOYEE_EDUCATION_TABLE_FIELDNAME].grid.add_new_row()
        var grid = frappe.web_form.fields_dict[EMPLOYEE_EDUCATION_TABLE_FIELDNAME].grid
        var data = grid.data[index]
        data["qualification"] = item.name
    })

    // Setting tel fields
    $.map(TEL_FIELDS, (tf) => {
        var field = frappe.web_form.fields_dict[tf];
        var inputs = field.$input;
        if (inputs.length > 0) {
            var input = inputs[0]
            input.type = "tel"
        }
    })

    try {
        var submit_btns = $("button.btn-primary");
        $.map(submit_btns, submit_btn => {
            // var submit_btn = $("button.btn-primary")[0];
            //submit_btn.type = "button";
            //submit_btn.setAttribute("onclick", "javascript:window.validateForm();")
        })
    } catch (err) {

    }
    frappe.web_form.refresh()

}

function validateTel(value) {
    value = value ? value : ""
    // if (!value) {
    //     return false
    // }
    if (value.match(TEL_PATTERN)) {
        return true
    }
    return false
}

function findInArray(arr, value) {
    return arr.find((item) => {
        return item == value
    })
}

function all(arr, value) {
    return arr.every((item) => {
        return item == value
    })
}

// $("button[type='submit'].submit-btn").on("click", (event) => {
// })

function validateForm() {
    // var fields = frappe.web_form.fields;
    var form_valid = [];
    var fields = frappe.web_form.fields_list;
    var valid_tel = false;
    var invalid_tel_fields = [];
    var invalid_tel_field_values = [];
    $.map(fields, (field) => {
        var fieldname = field.df.fieldname;
        var label = field.df.label;
        if (findInArray(TEL_FIELDS, fieldname)) {
            var field_value = field.value;
            var valid = validateTel(field_value)
            form_valid.push(valid)
            valid_tel = valid;
            if (!valid) {
                invalid_tel_fields.push(label)
                invalid_tel_field_values.push(field_value)
            }
        }
    })
    if (all(form_valid, true)) {
        $("form.web-form").submit()
    } else {
        if (valid_tel) {
            alert("invalid form!")
        } else {
            var temp = "";
            // $.map(invalid_tel_fields, (item, index) => {
            //     temp += item
            //     if (index + 1 < invalid_tel_fields.length) {
            //         temp += ", "
            //     }
            // })
            $.map(invalid_tel_field_values, (item, index) => {
                item = item ? item : ""
                temp += item
                if (index + 1 < invalid_tel_fields.length) {
                    temp += ", "
                }
            })
            alert(`invalid mobile no. : ${temp}`)
        }
    }
}

// $("form.web-form").on("submit", (event) => {
//     event.preventDefault();
//     // $("form.web-form").submit()
//     var fields = frappe.web_form.fields;
//     $.map(fields, (field) => {
//         if (field in TEL_FIELDS) {
//             alert("field found")
//         }
//     })
//     // $(this).submit()
// })

window.validateForm = validateForm
window.validateTel = validateTel
