$(document).ready(function () {
    jQuery.loadMakes = function ($this) {
        $.getJSON('/JSON/' + $this.val() + '.json', function (response) {
            carData = response;
            let seenMakes = [];
            var listitems = '';
            for (let dataKey in carData) {
                if (carData.hasOwnProperty(dataKey)) {
                    if ($.inArray(carData[dataKey]['make'], seenMakes) === -1) {
                        seenMakes.push(carData[dataKey]['make']);
                        listitems += '<option value="' + carData[dataKey]['make_slug'] + '">'
                            + carData[dataKey]['make'] + '</option>';
                    }
                }
            }
            let carMake = $('.carsearch #make');
            carMake.empty().append(listitems).prop('disabled', false);
            carMake.html(carMake.find('option').sort(function (x, y) {
                // to change to descending order switch "<" for ">"
                return $(x).text() > $(y).text() ? 1 : -1;
            }));
            carMake.prepend('<option disabled selected>Select Make</option><option value="any">Any</option>');
            carMake.prop('selectedIndex', 0);


            let carModel = $('.carsearch #model');
            carModel
                .empty()
                .append('<option disabled selected>Select Make</option>')
                .prop('disabled', true)
                .prop('selectedIndex', 0);
            $('#car-search').attr('action', "/cars/in/" + $('.carsearch #location').val());
        }).fail(function () {
            let carMake = $('.carsearch #make');
            carMake
                .empty()
                .append('<option disabled selected>Select Location</option>')
                .prop('disabled', true)
                .prop('selectedIndex', 0);

            let carModel = $('.carsearch #model');
            carModel
                .empty()
                .append('<option disabled selected>Select Location</option>')
                .prop('disabled', true)
                .prop('selectedIndex', 0);
        });
    }

    jQuery.loadModels = function ($this) {
        let seenModels = [];
        var listitems = '';
        let carModel = $('.carsearch #model');

        if ($this.val() === 'any') {
            carModel
                .empty()
                .append('<option disabled selected>Select Model</option>')
                .prop('disabled', true);
        } else {
            for (let dataKey in carData) {
                if (carData.hasOwnProperty(dataKey)) {
                    if (carData[dataKey]['make_slug'] === $this.val()) {
                        if ($.inArray(carData[dataKey]['model'], seenModels) === -1) {
                            seenModels.push(carData[dataKey]['model']);
                            listitems += '<option value="' + carData[dataKey]['model_slug'] + '">'
                                + carData[dataKey]['model'] + '</option>';
                        }
                    }
                }
            }
            carModel
                .empty()
                .append(listitems);

            carModel.html(carModel.find('option').sort(function (x, y) {
                // to change to descending order switch "<" for ">"
                return $(x).text() > $(y).text() ? 1 : -1;
            }));
            carModel
                .prepend('<option disabled selected>Select Model</option><option value="any">Any</option>')
                .prop('disabled', false)
                .prop('selectedIndex', 0);

            $('#car-search').attr('action', "/cars/" + $this.val() + "/in/"
                + $('.carsearch #location').val());
        }
    }

    jQuery.carSort = function ($this) {
        let showMore = $('.showmore__button');
        let shownItems = $('.results__block .result__item.shown');
        let length = shownItems.length;
        if (length < 12) {
            length = 12;
        }

        shownItems.removeClass('shown').fadeOut().addClass('not-shown').promise().done(function () {
            let carlist = $('.results__block .result__item');
            let sortBy = $this.data('sortby');
            let ascending = $this.data('sortascending');
            let sortNumerical = $this.data('sortnumerical');
            if (typeof carlist !== undefined) {
                if (ascending === true) {
                    if (sortNumerical) {
                        carlist.sort(function (a, b) {
                            return (+$(a).data(sortBy) < +$(b).data(sortBy)) ?
                                -1 : (+$(a).data(sortBy) > +$(b).data(sortBy)) ?
                                    1 : 0;
                        });
                    } else {
                        carlist.sort(function (a, b) {
                            return $(a).data(sortBy).toUpperCase().localeCompare($(b).data(sortBy).toUpperCase());
                        });
                    }
                } else {
                    if (sortNumerical) {
                        carlist.sort(function (a, b) {
                            return (+$(a).data(sortBy) > +$(b).data(sortBy)) ?
                                -1 : (+$(a).data(sortBy) < +$(b).data(sortBy)) ?
                                    1 : 0;
                        });
                    } else {
                        carlist.sort(function (a, b) {
                            return $(b).data(sortBy).toUpperCase().localeCompare($(a).data(sortBy).toUpperCase());
                        });
                    }
                }
                $('.results__block').html(carlist).promise().done(function () {
                    $('.results__block .result__item.not-shown:not(.filter-out):lt(' + length + ')')
                        .removeClass('not-shown').fadeIn('slow').addClass('shown');
                    let moreItems = $('.results__block .result__item.not-shown');
                    if (moreItems.length > 0) {
                        showMore.fadeIn();
                    }
                });
            }
        });
    }

    jQuery.searchForAddressesFromPostcode = function () {
        let postcode = $('#' + $.addressContainerId + ' input[name="postcode"]').val();
        let searchResults = $('#' + $.addressContainerId + ' .postcodesearchresults');

        // Remove old address select input options
        $('#' + $.addressContainerId + ' .address-options').remove();

        if (postcode !== '') {
            $.ajax({
                url: "//services.postcodeanywhere.co.uk/CapturePlus/Interactive/Find/v2.10/json3.ws",
                dataType: "jsonp",
                data: {
                    key: "MG19-XC55-DT27-KX11",
                    searchFor: "Everything",
                    country: 'GB',
                    searchTerm: postcode,
                    lastId: ""
                },
                success: function (response) {

                    //console.log(response.Items);

                    let list = document.createElement("select");

                    list.setAttribute("class", "form-control address-options");
                    searchResults.append(list);

                    // When an address is selected
                    $(document).on('change', '#' + $.addressContainerId + ' .address-options', function (e) {
                        //console.log(e);
                        var addressId = $(e.target).val();
                        if (addressId === "") $('#' + $.addressContainerId + ' .address-inputs').fadeIn("fast");
                        else $.retrieveAddressFromOptions(addressId);
                        //return;
                    });

                    let defaultOption = document.createElement("option");
                    defaultOption.text = "Select an address (" + response.Items.length + ")";
                    defaultOption.setAttribute("value", "");
                    defaultOption.setAttribute("selected", "selected");
                    list.append(defaultOption);

                    let altOption = document.createElement("option");
                    altOption.text = "My address is not listed here";
                    altOption.setAttribute("value", "");
                    list.append(altOption);

                    for (let i = 0; i < response.Items.length; i++) {
                        let option = document.createElement("option");
                        option.setAttribute("value", response.Items[i].Id);
                        option.text = response.Items[i].Text + " " + response.Items[i].Description;
                        option.setAttribute("class", response.Items[i].Type)
                        list.append(option);
                    }
                }
            });
        }
    }

    jQuery.retrieveAddressFromOptions = function (id) {
        $.ajax({
            url: "//services.postcodeanywhere.co.uk/CapturePlus/Interactive/Retrieve/v2.10/json3.ws",
            dataType: "jsonp",
            data: {
                key: "MG19-XC55-DT27-KX11",
                id: id,
                Language: 'ENG'
            },
            success: function (data) {
                if (data.Items.length) {
                    $.each(data.Items, function () {
                        if (this.Language === 'ENG') {
                            $.addressLookedUp = true;
                            $('#' + $.addressContainerId + ' input[name="flat"]').val(this.Block);
                            $('#' + $.addressContainerId + ' input[name="house_name"]').val(this.BuildingName);
                            $('#' + $.addressContainerId + ' input[name="house_number"]').val(this.BuildingNumber);
                            $('#' + $.addressContainerId + ' input[name="street"]').val(this.Street);
                            $('#' + $.addressContainerId + ' input[name="district"]').val(this.District);
                            $('#' + $.addressContainerId + ' input[name="towncity"]').val(this.City);
                            $('#' + $.addressContainerId + ' input[name="county"]').val(this.Province);
                            $('#' + $.addressContainerId + ' input[name="postcode"]').val(this.PostalCode);
                            $('#' + $.addressContainerId + ' .address-inputs').fadeOut("fast");
                            return false;
                        }
                    });
                }
            }
        });
    }

    jQuery.cnsFormError = function () {
        let error = false;
        $('.error').each(function (i, ele) {
            $(ele).fadeOut();
        });
        $('input').each(function (i, ele) {
            let $this = $(ele);
            if ($this.hasClass('required') && $this.val() === '') {
                error = true;
                $('.' + $this.attr('name') + '_error').fadeIn();
            }
        });
        return error;
    }

    jQuery.addressContainerId = 'addressLookup';
    jQuery.addressLookedUp = false;

    let carData = {};
    let carModels = [];

    $('.sortby').on('click', function () {
        let $this = $(this);
        let sortButton = $('.sort__button');
        sortButton.data('sortby', $this.data('sortby'));
        sortButton.data('sortascending', $this.data('sortascending'));
        sortButton.data('sortnumerical', $this.data('sortnumerical'));
        $('.sortinfo').text($this.text());
        $('#sort-group').slideUp('fast');
        $.carSort($this);
    });

    if ($('.carsearch__wrapper')[0]) {
        $('.group__button, .sort__button').on('click', function (e) {
            e.preventDefault();
            if ($(this).hasClass('sort__button')) {
                let shownItems = $('.results__block .result__item.shown');
                if (shownItems.length === 0) {
                    return;
                }
            }
            let $this = $(this);
            $this.toggleClass('group__button--selected');
            $('#' + $this.data('group')).slideToggle('fast');
        });
    }

    $('#default-sortoption').click();

    let filterAttributes = [
        //'enginecapacity',
        'bodytype',
        'transmission',
        'fueltype',
        'seats',
        'doors'
    ];

    filterData = {
        'enginecapacity': {
            '0-1000': 'Under 1000',
            '1000-1500': '1000 - 1499',
            '1500-2000': '1500 - 1999',
            '2000-9999': '2000+'
        }
    };
    let filterChoices = {};
    let filterChoicesMinMax = {};

    let dataVal = '';
    $('.results__block .result__item').each(function (i, ele) {
        let $this = $(ele);
        filterAttributes.forEach(function (filterAttribute, index) {
            dataVal = $this.data(filterAttribute);
            if (filterData[filterAttribute] === undefined) {
                filterData[filterAttribute] = {};
            }

            if (dataVal !== '') {
                filterData[filterAttribute][dataVal] = dataVal;
            }
        });
    });

    let filterOptions = '';
    let inputValue = '';
    for (let filterAttribute in filterData) {
        filterOptions += '<li><label for="' + filterAttribute
            + '_option0"><input type="radio" value="any" id="' + filterAttribute + '_option0"\n' +
            'name="' + filterAttribute + '"/>Any</label></li>'

        if (filterData.hasOwnProperty(filterAttribute)) {
            let filterAttributeSorted = filterData[filterAttribute];
            if (filterAttributes.indexOf(filterAttribute) !== -1) {
                filterAttributeSorted = Object.keys(filterData[filterAttribute]).sort(function (a, b) {
                    if (typeof filterData[filterAttribute][a].toUpperCase === 'function') {
                        return filterData[filterAttribute][a].toUpperCase().localeCompare(filterData[filterAttribute][b].toUpperCase());
                    } else {
                        return (+filterData[filterAttribute][a] < +filterData[filterAttribute][b]) ?
                            -1 : (+filterData[filterAttribute][a] > +filterData[filterAttribute][b]) ?
                                1 : 0;
                    }
                });
            }

            let num = 0;
            for (let sortedKey in filterAttributeSorted) {
                if (filterAttributeSorted.hasOwnProperty(sortedKey)) {
                    inputValue = sortedKey;
                    if (Array.isArray(filterAttributeSorted)) {
                        inputValue = filterAttributeSorted[sortedKey];
                    }
                    num = num + 1;
                    filterOptions += '<li><label for="' + filterAttribute + '_option' + num
                        + '"><input type="radio" value="' + inputValue
                        + '" id="' + filterAttribute + '_option' + num + '"\n'
                        + 'name="' + filterAttribute + '"/>' + filterAttributeSorted[sortedKey] + '</label></li>';
                }
            }
        }

        $('#' + filterAttribute + '-group').html(filterOptions);
        filterOptions = '';
    }

    $('.filter__section input').on('change', function () {
        $('.results__block .result__item.filter-out').removeClass('filter-out');
        let shownItems = $('.results__block .result__item.shown');
        let length = shownItems.length;
        if (length < 12) {
            length = 12;
        }
        let $this = $(this);
        if ($this.is(':checked')) {
            filterChoices[$this.attr('name')] = $this.val();
            if ($this.attr('name') === 'enginecapacity' && $this.val() !== 'any') {
                let minMax = $this.val().split('-');
                filterChoicesMinMax[$this.attr('name') + '_min'] = parseInt(minMax[0]);
                filterChoicesMinMax[$this.attr('name') + '_max'] = parseInt(minMax[1]);
            }
            $('.results__block .result__item').each(function (i, ele) {
                let item = $(ele);
                let filterOut = false;
                for (let dataKey in filterChoices) {
                    if (filterChoices.hasOwnProperty(dataKey) && filterChoices[dataKey] !== 'any') {
                        if (dataKey === 'enginecapacity') {
                            if (!(item.data(dataKey) >= filterChoicesMinMax[dataKey + '_min'] &&
                                item.data(dataKey) < filterChoicesMinMax[dataKey + '_max'])) {
                                filterOut = true;
                                break;
                            }
                        } else {
                            if (item.data(dataKey).toString() !== filterChoices[dataKey]) {
                                filterOut = true;
                                break;
                            }
                        }
                    }
                }
                if (filterOut) {
                    item.addClass('filter-out');
                }
            });

            shownItems.removeClass('shown').fadeOut().addClass('not-shown');

            $('.results__block .result__item.not-shown:not(.filter-out):lt(' + length + ')')
                .removeClass('not-shown')
                .fadeIn('slow')
                .addClass('shown');

            shownItems = $('.results__block .result__item.shown');
            let noResults = $('.no-results');
            let showMore = $('.showmore__button');
            if (shownItems.length === 0) {
                if (noResults.hasClass('d-none')) {
                    noResults.removeClass('d-none');
                    showMore.fadeOut();
                }
            } else {
                if (noResults.hasClass('d-none') === false) {
                    noResults.addClass('d-none');
                }
            }
            let moreItems = $('.results__block .result__item.not-shown:not(.filter-out)');
            if (moreItems.length > 0) {
                showMore.fadeIn();
            } else {
                showMore.fadeOut();
            }
        }
    });

    let searchLocation = $('.carsearch #location');
    searchLocation.on('change', function (e) {
        $.loadMakes($(this));
    });

    let searchMake = $('.carsearch #make');
    searchMake.on('change', function (e) {
        $.loadModels($(this));
    });

    let searchModel = $('.carsearch #model');
    searchModel.on('change', function (e) {
        $('#car-search')
            .attr('action', "/cars/" + $('.carsearch #make')
                .val() + "/" + $(this).val() + "/in/" + $('.carsearch #location').val());
    });

    let showMore = $('.showmore__button');
    showMore.on('click', function (e) {
        $this = $(this);
        $this.fadeOut();
        $('.results__block .result__item.not-shown:lt(12)').removeClass('not-shown').fadeIn('slow').addClass('shown');
        let moreItems = $('.results__block .result__item.not-shown');
        if (moreItems.length > 0) {
            $this.fadeIn();
        }
    });

    if (searchLocation.val() !== null && searchLocation.val() !== undefined) {
        $.loadMakes(searchLocation);
    }

    $('input[name="location"],input[name="make"],input[name="model"]').on('change', function (e) {
        let $this = $(this);
        if ($this.is(':checked')) {
            let searchLocation = $("input[name='location']:checked");
            let searchMake = $("input[name='make']:checked");
            let searchModel = $("input[name='model']:checked");
            let searchForm = $('#search-form');
            let formAction = '/cars';
            if (searchMake.val() && searchMake.val() !== 'any') {
                formAction = formAction + '/' + searchMake.val();
            }
            if ($this.attr('name') !== 'make' && searchModel.val() && searchModel.val() !== 'any') {
                formAction = formAction + '/' + searchModel.val();
            }
            formAction = formAction + '/in/' + searchLocation.val();

            searchForm.attr('action', formAction);
            searchForm.submit();
        }
    });

    $('.ribbon-close').on('click', function (e) {
        $('.top__ribbon').fadeOut();
    });

    $('.title__button:not(.seleted)').on('click', function (e) {
        let $this = $(this);
        $('.title__button.selected').removeClass('selected');
        $this.addClass('selected');
        $('#title').val($this.html());
        $('.title_error').fadeOut();
    });

    $('#formstep1').on('submit', function (e) {
        let error = jQuery.cnsFormError();

        let checkAddress = $('#' + $.addressContainerId + ' input[name="street"]').val()
            + $('#' + $.addressContainerId + ' input[name="towncity"]').val();
        if (checkAddress === '') {
            $('.lookup_error').fadeIn();
            error = true;
        }

        if (error) {
            e.preventDefault();
        }
    });

    $('.licence__button:not(.seleted)').on('click', function (e) {
        let $this = $(this);
        $('.licence__button.selected').removeClass('selected');
        $this.addClass('selected');
        $('#licence').val($this.html());
        $('.licence_error').fadeOut();
    });

    $('#formstep2, #financestep1').on('submit', function (e) {
        if (jQuery.cnsFormError()) {
            e.preventDefault();
        }
    });

    $('#bespokestep0').on('submit', function (e) {
        if ($('#carreg').val() !== '') {
            $('#mileage').addClass('required');
        }

        let depositField = $('#depositamount');
        if (parseInt(depositField.val()) < 99) {
            depositField.val('99');
        }

        if (jQuery.cnsFormError()) {
            e.preventDefault();
        }
    });

    $('input').focusout(function (e) {
        let $this = $(this);
        if ($this.hasClass('required') && $this.val() !== '') {
            $('.' + $this.attr('name') + '_error').fadeOut();
        }
    });

    $('.day__button:not(.selected)').on('click', function (e) {
        let $this = $(this);
        $('.day__button.selected').removeClass('selected');
        $this.addClass('selected');
        $('#appointment_date').val($this.data('date'));
        $('#appointment_time').val('');
        $('.appointment_date_error').fadeOut();

        let dayData = {};
        for (let dataKey in appointmentCalendar) {
            if (appointmentCalendar.hasOwnProperty(dataKey)) {
                console.log(['timestamp', appointmentCalendar[dataKey]['timeStamp'], $this.data('timestamp')]);
                if (appointmentCalendar[dataKey]['timeStamp'] === $this.data('timestamp')) {
                    dayData = appointmentCalendar[dataKey]['times'];
                    break;
                }
            }
        }
        let daysHtml = '';
        for (let dataKey in dayData) {
            let timeNameSuffix = '';
            let timeName = '';
            let timeValue = '';
            let disabled = '';
            let disabledClass = '';

            if (dayData[dataKey]['disabled']) {
                disabled = ' disabled="disabled"';
                disabledClass = ' disabled';
            }
            if (appointmentMins !== undefined) {
                timeNameSuffix = ':' + appointmentMins;
            }
            if (dayData[dataKey]['hour'] > 12) {
                timeName = (dayData[dataKey]['hour'] - 12) + timeNameSuffix + 'pm';
            } else {
                timeName = dayData[dataKey]['hour'] + timeNameSuffix + 'am';
            }

            timeValue = dayData[dataKey]['hour'] + ':' + appointmentMins;

            daysHtml += '<div class="col-4 col-md mb-3">\n<button class="btn btn-whiteshadow time__button' +
                disabledClass + '" data-time="' + timeValue + '" type="button"' + disabled + '>' + timeName +
                '</button>\n</div>';
        }
        $('.time__selection').html(daysHtml);
    });

    $('input[name="outstandingfinance"]').on('change', function (e) {
        let $this = $(this);
        if ($this.val() === 'Yes') {
            $('.outstandingfinanceamount').fadeIn();
        } else {
            $('.outstandingfinanceamount').fadeOut();
        }
    });

    $('.outstandingfinance__button:not(.seleted)').on('click', function (e) {
        let $this = $(this);
        $('.outstandingfinance__button.selected').removeClass('selected');
        $this.addClass('selected');
        $('#outstandingfinance').val($this.html());
        if ($('#outstandingfinance').val() === 'Yes') {
            $('.outstandingfinanceamount').fadeIn();
        } else {
            $('.outstandingfinanceamount').fadeOut();
        }
        $('.outstandingfinance_error').fadeOut();
    });

    $('#carreg').on('focusout', function (e) {
        let $this = $(this);
        if ($this.val() !== '') {
            $('.isoutstandingfinance').fadeIn();
        } else {
            $('.isoutstandingfinance').fadeOut();
        }
    });

    $('.day__button').eq(0).click();

    //$('.time__button:not(.selected)').on('click', function (e) {

    $(document).on('click', '.time__button:not(.selected)', function (e) {
        let $this = $(this);
        $('.time__button.selected').removeClass('selected');
        $this.addClass('selected');
        $('#appointment_time').val($this.data('time'));
        $('.appointment_time_error').fadeOut();
    });

    $('#postcode').on('keyup', function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            $.searchForAddressesFromPostcode();
            return false;
        }
    });

    $('.lookup__button').on('click', function (e) {
        e.preventDefault();
        $.searchForAddressesFromPostcode();
        return false;
    });

    $('.print__button').click(function() {
        window.print();
        return false;
    });
});
