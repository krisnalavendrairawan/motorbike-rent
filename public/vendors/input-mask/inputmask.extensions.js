/*
 Input Mask plugin extensions
 http://github.com/RobinHerbots/jquery.inputmask
 Copyright (c) 2010 -  Robin Herbots
 Licensed under the MIT license (http://www.opensource.org/licenses/mit-license.php)
 Version: 0.0.0-dev

 Optional extensions on the jquery.inputmask base
 */
(function (factory) {
	if (typeof define === "function" && define.amd) {
		define(["inputmask.dependencyLib", "inputmask"], factory);
	} else if (typeof exports === "object") {
		module.exports = factory(require("./inputmask.dependencyLib.jquery"), require("./inputmask"));
	} else {
		factory(window.dependencyLib || jQuery, window.Inputmask);
	}
}
(function ($, Inputmask) {
	//extra definitions
	Inputmask.extendDefinitions({
		"A": {
			validator: "[A-Za-z\u0410-\u044F\u0401\u0451\u00C0-\u00FF\u00B5]",
			cardinality: 1,
			casing: "upper" //auto uppercasing
		},
		"&": { //alfanumeric uppercasing
			validator: "[0-9A-Za-z\u0410-\u044F\u0401\u0451\u00C0-\u00FF\u00B5]",
			cardinality: 1,
			casing: "upper"
		},
		"#": { //hexadecimal
			validator: "[0-9A-Fa-f]",
			cardinality: 1,
			casing: "upper"
		}
	});
	Inputmask.extendAliases({
		"url": {
			definitions: {
				"i": {
					validator: ".",
					cardinality: 1
				}
			},
			mask: "\\http://i{+}",
			insertMode: false,
			autoUnmask: false
		},
		"ip": { //ip-address mask
			mask: "i[i[i]].i[i[i]].i[i[i]].i[i[i]]",
			definitions: {
				"i": {
					validator: function (chrs, maskset, pos, strict, opts) {
						if (pos - 1 > -1 && maskset.buffer[pos - 1] !== ".") {
							chrs = maskset.buffer[pos - 1] + chrs;
							if (pos - 2 > -1 && maskset.buffer[pos - 2] !== ".") {
								chrs = maskset.buffer[pos - 2] + chrs;
							} else chrs = "0" + chrs;
						} else chrs = "00" + chrs;
						return new RegExp("25[0-5]|2[0-4][0-9]|[01][0-9][0-9]").test(chrs);
					},
					cardinality: 1
				}
			},
			onUnMask: function (maskedValue, unmaskedValue, opts) {
				return maskedValue;
			}
		},
		"email": {
			//https://en.wikipedia.org/wiki/Domain_name#Domain_name_space
			//https://en.wikipedia.org/wiki/Hostname#Restrictions_on_valid_host_names
			//should be extended with the toplevel domains at the end
			mask: "*{1,64}[.*{1,64}][.*{1,64}][.*{1,63}]@-{1,63}.-{1,63}[.-{1,63}][.-{1,63}]",
			greedy: false,
			onBeforePaste: function (pastedValue, opts) {
				pastedValue = pastedValue.toLowerCase();
				return pastedValue.replace("mailto:", "");
			},
			definitions: {
				"*": {
					validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
					cardinality: 1,
					casing: "lower"
				},
				"-": {
					validator: "[0-9A-Za-z\-]",
					cardinality: 1,
					casing: "lower"
				}
			},
			onUnMask: function (maskedValue, unmaskedValue, opts) {
				return maskedValue;
			}
		},
		"mac": {
			mask: "##:##:##:##:##:##"
		},
		//https://en.wikipedia.org/wiki/Vehicle_identification_number
		// see issue #1199
		"vin": {
			mask: "V{13}9{4}",
			definitions: {
				'V': {
					validator: "[A-HJ-NPR-Za-hj-npr-z\\d]",
					cardinality: 1,
					casing: "upper"
				}
			},
			clearIncomplete: true,
			autoUnmask: true
		},
        "phone": { // Phone Number mask
			mask: "(999) 9999-999[9]"
		},
        "handphone": { // Phone Number mask
			mask: "9999-9999-99[999]"
		},
		"nik": {
            mask: "9999999999999999",
            definitions: {
                "9": {
                    validator: "[0-9]",
                    cardinality: 1
                }
            },
            placeholder: "0",
            clearIncomplete: true,
            autoUnmask: true,
            onBeforePaste: function (pastedValue, opts) {
                return pastedValue.replace(/[^\d]/g, '');
            }
        },
		"driverLicense": {
            mask: "99-999999-9999",
            definitions: {
                "9": {
                    validator: "[0-9]",
                    cardinality: 1
                }
            },
            placeholder: "0",
            clearIncomplete: true,
            autoUnmask: true,
            onBeforePaste: function (pastedValue, opts) {
                // Hapus karakter non-angka dan karakter '-'
                return pastedValue.replace(/[^\d-]/g, '');
            },
        },

"indonesianPlate": {
    mask: 'a{1,2} 9{1,4} a{0,3}',  // Format lebih fleksibel
    definitions: {
        "a": {
            validator: "[A-Za-z]",
            casing: "upper"
        },
        "9": {
            validator: "[0-9]"
        }
    },
    clearIncomplete: false,
    autoUnmask: false,
    greedy: false,
    placeholder: "_",
    showMaskOnFocus: true,
    showMaskOnHover: false,
    // Tambahkan ini untuk mempertahankan nilai asli
    onBeforeMask: function (value) {
        if (!value) return value;
        // Bersihkan dan format nilai
        return value.toString()
            .replace(/[^A-Za-z0-9]/g, ' ')  // Ganti non alfanumerik dengan spasi
            .replace(/\s+/g, ' ')           // Normalize spasi
            .trim()
            .toUpperCase();
    },
    onBeforePaste: function (pastedValue) {
        return pastedValue.toUpperCase().replace(/[^A-Z0-9\s]/g, '');
    }
},
			
			"indonesianCurrency": {
				alias: "numeric",
				groupSeparator: ".",
				radixPoint: ",",
				autoGroup: true,
				prefix: "Rp ",
				digits: 0,
				digitsOptional: false,
				clearMaskOnLostFocus: false,
				removeMaskOnSubmit: true,
				autoUnmask: true,
				onBeforeMask: function(value, opts) {
					// Remove all non-digits and convert to number
					value = value.toString().replace(/[^\d]/g, "");
					return value;
				},
				onUnMask: function(maskedValue, unmaskedValue) {
					// Return only numbers when the form is submitted
					return unmaskedValue.replace(/[^\d]/g, "");
				}
		}
		
	});
	return Inputmask;
}));
