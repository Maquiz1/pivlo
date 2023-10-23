function hexToRGB(e, t) {
  var a = parseInt(e.slice(1, 3), 16),
    o = parseInt(e.slice(3, 5), 16),
    e = parseInt(e.slice(5, 7), 16);
  return t
    ? "rgba(" + a + ", " + o + ", " + e + ", " + t + ")"
    : "rgb(" + a + ", " + o + ", " + e + ")";
}
!(function (a) {
  "use strict";
  function e() {
    (this.$body = a("body")),
      (this.charts = []),
      (this.defaultColors = ["#3bc0c3", "#4489e4", "#d03f3f", "#716cb0"]);
  }
  (e.prototype.boundariesExample = function () {
    var e = document.getElementById("boundaries-example"),
      t = e.getAttribute("data-colors"),
      t = t ? t.split(",") : this.defaultColors,
      e = e.getContext("2d"),
      e = new Chart(e, {
        type: "line",
        data: {
          labels: ["Jan", "Feb", "March", "April", "May", "June"],
          datasets: [
            {
              label: "Fully Rounded",
              data: [12.5, -19.4, 14.3, -15, 10.8, -10.5],
              borderColor: t[0],
              backgroundColor: hexToRGB(t[0], 0.3),
              fill: !1,
            },
          ],
        },
        options: {
          responsive: !0,
          maintainAspectRatio: !1,
          plugins: { legend: { display: !1, position: "top" } },
          scales: {
            x: { grid: { display: !1 } },
            y: { grid: { display: !1 } },
          },
        },
      });
    this.charts.push(e);
  }),
    (e.prototype.datasetExample = function () {
      var e = document.getElementById("dataset-example"),
        t = e.getAttribute("data-colors"),
        t = t ? t.split(",") : this.defaultColors,
        e = e.getContext("2d"),
        e = new Chart(e, {
          type: "line",
          data: {
            labels: ["Jan", "Feb", "March", "April", "May", "June"],
            datasets: [
              {
                label: "D0",
                data: [10, 20, 15, 35, 38, 24],
                borderColor: t[0],
                hidden: !0,
                backgroundColor: hexToRGB(t[0], 0.3),
              },
              {
                label: "D1",
                data: [12, 18, 18, 33, 41, 20],
                borderColor: t[1],
                fill: "-1",
                backgroundColor: hexToRGB(t[1], 0.3),
              },
              {
                label: "D2",
                data: [5, 25, 20, 25, 28, 14],
                borderColor: t[2],
                fill: 1,
                backgroundColor: hexToRGB(t[2], 0.3),
              },
              {
                label: "D3",
                data: [12, 45, 15, 35, 38, 24],
                borderColor: t[3],
                fill: "-1",
                backgroundColor: hexToRGB(t[3], 0.3),
              },
              {
                label: "D4",
                data: [24, 38, 35, 15, 20, 10],
                borderColor: t[4],
                fill: 8,
                backgroundColor: hexToRGB(t[4], 0.3),
              },
            ],
          },
          options: {
            responsive: !0,
            maintainAspectRatio: !1,
            plugins: { filler: { propagate: !1 } },
            interaction: { intersect: !1 },
            scales: {
              x: { grid: { display: !1 } },
              y: { stacked: !0, grid: { display: !1 } },
            },
          },
        });
      this.charts.push(e);
    }),
    (e.prototype.init = function () {
      var t = this;
      (Chart.defaults.font.family =
        '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif'),
        (Chart.defaults.color = "#8391a2"),
        (Chart.defaults.scale.grid.color = "#8391a2"),
        this.boundariesExample(),
        this.datasetExample(),
        a(window).on("resizeEnd", function (e) {
          a.each(t.charts, function (e, t) {
            try {
              t.destroy();
            } catch (e) {}
          }),
            t.boundariesExample(),
            t.datasetExample();
        }),
        a(window).resize(function () {
          this.resizeTO && clearTimeout(this.resizeTO),
            (this.resizeTO = setTimeout(function () {
              a(this).trigger("resizeEnd");
            }, 500));
        });
    }),
    (a.ChartJs = new e()),
    (a.ChartJs.Constructor = e);
})(window.jQuery),
  (function () {
    "use strict";
    window.jQuery.ChartJs.init();
  })();
