(function() { 

    // Font color for values inside the bar
    var insideFontColor = '255,255,255';
    // Font color for values above the bar
    var outsideFontColor = '0,0,0';
    // How close to the top edge bar can be before the value is put inside it
    var topThreshold = 20;

    this.initCanvas = function(canvas){
        if (window.G_vmlCanvasManager && window.attachEvent && !window.opera) {
            canvas = window.G_vmlCanvasManager.initElement(canvas);
        }
        return canvas;
    }; 

    this.fadeIn = function(ctx, obj, x, y, black, step) {
        var ctx = this.modifyCtx(ctx);
        var alpha = 0;
        ctx.fillStyle = black ? 'rgba(' + this.outsideFontColor + ',' + step + ')' : 'rgba(' + this.insideFontColor + ',' + step + ')';
        ctx.fillText(obj, x, y);
    };
    this.modifyCtx = function(ctx) {
        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
        ctx.textAlign = 'center';
        ctx.textBaseline = 'bottom';
        return ctx;
    };

    this.drawValue = function(context, step) {
        var ctx = context.chart.ctx;
        context.data.datasets.forEach(function (dataset) {
            for (var i = 0; i < dataset.data.length; i++) {
                var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model;
                var textY = (model.y > this.topThreshold) ? model.y - 3 : model.y + 20;
                this.fadeIn(ctx, dataset.data[i], model.x, textY, model.y > this.topThreshold, step);
            }
        });
    };

    this.exportToImage = function(id){
        return document.getElementById(id).toDataURL('image/png');
    }
})(window);
