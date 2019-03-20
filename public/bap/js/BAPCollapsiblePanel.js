Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};
Array.prototype.contains = function(obj) {
    var i = this.length;
    while (i--) {
        if (this[i] === obj) {
            return true;
        }
    }
    return false;
};


(function ($) {
    $.fn.extend({

        collapsiblePanel: function () {

            Storages.alwaysUseJsonInStorage(true);

            var storage = Storages.localStorage;

            var panels = storage.get('closablePanels');

            if(panels === null ){
                panels = new Array();
            }

            $(this).each(function () {

                var attached = $(this).attr('data-collapsible');

                if (attached === 'true') {
                    return true;
                }

                $(this).attr('data-collapsible', 'true');

                var indicator = $(this).find('.expander').first();
                var header = $(this).find('.card-inside-title').first();
                var content = $(this).find('.panel-content').first();

                if(panels.contains(header.attr('id'))){
                    indicator.find('i').removeClass('fa fa-angle-up').addClass('fa fa-angle-down');
                    content.hide();
                }


                header.click(function (event) {

                    var target = $(event.target);
                    if (target.is("a")) {

                    } else {
                        content.slideToggle(500, function () {

                            if (content.is(':visible')) {

                                panels.remove(header.attr('id'))

                                indicator.find('i').removeClass('fa fa-angle-down').addClass('fa fa-angle-up');
                            } else {

                                panels.push(header.attr('id'));

                                indicator.find('i').removeClass('fa fa-angle-up').addClass('fa fa-angle-down');
                            }

                            storage.set('closablePanels',panels);
                        });
                    }


                });
            });
        }
    });
})(jQuery);
