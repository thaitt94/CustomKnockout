define([
    'jquery',
    'uiComponent',
    'mage/validation',
    'ko',
    'Magento_Ui/js/modal/modal'
    ],
    function ($, Component, validation, ko, modal) {
        'use strict';
        return Component.extend({
        	defaults: {
                template: 'Thai_Knockout1/list'
            },
            totalEmployee: ko.observableArray([]),
            initialize: function (config) {
                this._super();
                if (config.employees.length > 0) {
                    this.totalEmployee(config.employees);
                    return this;
                }
            },

            save: function (data)
            {
                var employee = {},
                self = this,
                formDataArray = $(data).serializeArray();
                //foreach saveData to {'key': 'value'}
                formDataArray.forEach(function (entry) {
                    employee[entry.name] = entry.value;
                });
                if($(data).validation() && $(data).validation('isValid')) {
                    $.ajax({
                        url: 'save',
                        data: JSON.stringify(employee),
                        type: "POST",
                        dataType: 'json',
                    })
                    .done(
                        function (response) {
                            if (response) {
                                $.each(response, function (i, v) {
                                    var indx = self.findIndex(self.totalEmployee(), v.entity_id);
                                    if(indx == -1) {
                                        self.totalEmployee.unshift(v);
                                    } else {
                                        var oldItem = self.totalEmployee()[indx];
                                        self.totalEmployee.replace(oldItem, v);
                                    }
                                });
                            }
                        }
                    )
                    $('.action-close').click();
                }
            },

            findIndex: function (arr,id) {
                var ind = -1;
                arr.forEach(function(item, index){
                    if (item.entity_id == id) {
                        ind = index;
                    }
                });
                return ind;
            },

            remove: function (item)
            {
                var confirm_delete = confirm('Are you sure to delete ' + item.full_name + ' ?');
                var self = this;
                if (confirm_delete) {
                    var data = item;
                    $.ajax({
                        url: 'delete',
                        data: data,
                        type: "POST",
                        dataType: 'json',
                    })
                    .done(
                        function (response) {
                            if (response) {
                                self.totalEmployee.remove(function (employee) {
                                    return employee.entity_id == response.entity_id;
                                });
                            }
                        }
                    )
                }
            },

            createPopup: function(employee, event) {
                var elmPopup = $("#employee-form-popup");
                $( "#dob" ).datepicker();
        	    if (employee.entity_id == null) {
                    let option = {
                        'type': 'popup',
                        'title': 'Add employee',
                        'responsive': true,
                        'buttons': [{
                            text: 'Cancel',
                            class: 'action',
                            click: function () {
                                $(elmPopup).find("input").val("");
                                $(elmPopup).find("select").val("");
                                this.closeModal();
                            }
                        }],
                        closed: function () {
                        }
                    };
                    modal(option, $(elmPopup));
                    $(elmPopup).modal("openModal");
                } else {
                    var option = {
                        'type': 'popup',
                        'title': $.mage.__("Edit employee: %1").replace("%1", employee.full_name),
                        'responsive': true,
                        'buttons': [{
                            text: 'Cancel',
                            class: 'action',
                            click: function () {
                                $(elmPopup).find("input").val("");
                                $(elmPopup).find("select").val("");
                                this.closeModal();
                            }
                        }],
                        closed: function () {
                        }
                    };

                    modal(option, $(elmPopup));
                    $(elmPopup).find("input[name=entity_id]").val(employee.entity_id);
                    $(elmPopup).find("input[name=full_name]").val(employee.full_name);
                    $(elmPopup).find("input[name=email]").val(employee.email);
                    $(elmPopup).find("input[name=dob]").val(employee.dob);
                    $(elmPopup).find("input[name=salary]").val(employee.salary);
                    $(elmPopup).find("select[name=department]").val(employee.department);
                    $(elmPopup).find("select[name=position]").val(employee.position);
                    $(elmPopup).modal("openModal");
                }

            },
        });
    }
);
