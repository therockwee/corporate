(function($){
	"use strict";
	var defaults = {
		formula: {},
		currency: "$",
		currencyPosition: "before",
		thousandthSeparator: ",",
		decimalSeparator: ".",
		updateHidden: ""
	};

	var methods =
	{
		init: function(options){
			return this.each(function(){
				options = $.extend(false, defaults, options);
				$(this).data("cost-calculator-options", options);
				$(this).costCalculator("calculate");
			});
		},
		calculate : function(options){
			return this.each(function(){
				options = $(this).data("cost-calculator-options");
				var sum_array = options.formula.split("+");
				var mult_array;
				var sum = 0;
				var mult = 1;
				for(var i in sum_array)
				{
					mult_array = sum_array[i].split("*");
					if(mult_array.length>1)
					{
						mult = 1;
						for(var j in mult_array)
							mult = mult * (!isNaN($("#" + mult_array[j]).val()) ? $("#" + mult_array[j]).val() : 0);
						sum = sum + mult;
					}
					else
						sum = sum + (!isNaN(parseFloat($("#" + sum_array[i]).val())) ? parseFloat($("#" + sum_array[i]).val()) : 0);
				}
				// /\d(?=(\d{3})+\.)/g
				var regex = new RegExp("\\d(?=(\\d{3})+\\" + options.decimalSeparator + ")", "g");
				$(this).html((options.currencyPosition=="before" ? options.currency : '')+sum.toFixed(2).replace(".", options.decimalSeparator).replace(regex, '$&' + options.thousandthSeparator)+(options.currencyPosition=="after" ? options.currency : ''));
				if(jQuery.type(options.updateHidden)=="object")
					options.updateHidden.val(options.currency+sum.toFixed(2).replace(".", options.decimalSeparator).replace(regex, '$&' + options.thousandthSeparator));
			});
		}
	};

	jQuery.fn.costCalculator = function(method){
		if(methods[method])
			return methods[method].apply(this, arguments);
		else if(typeof(method)==='object' || !method)
			return methods.init.apply(this, arguments);
	};
})(jQuery);