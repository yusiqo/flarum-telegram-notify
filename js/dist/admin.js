(() => {
    var t = {
            n: n => {
                var i = n && n.__esModule ? () => n.default : () => n;
                return t.d(i, {
                    a: i
                }), i
            },
            d: (n, i) => {
                for (var a in i) t.o(i, a) && !t.o(n, a) && Object.defineProperty(n, a, {
                    enumerable: !0,
                    get: i[a]
                })
            },
            o: (t, n) => Object.prototype.hasOwnProperty.call(t, n),
            r: t => {
                "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(t, Symbol.toStringTag, {
                    value: "Module"
                }), Object.defineProperty(t, "__esModule", {
                    value: !0
                })
            }
        },
        n = {};
    (() => {
        "use strict";
        t.r(n);
        const i = flarum.core.compat["admin/app"];
        var a = t.n(i);

        a().initializers.add("telegram-notify", function() {
            a().extensionData.for("telegram-notify")
                .registerSetting({
                    label: a().translator.trans("telegram-notify.admin.settings.bot-token.label"),
                    setting: "telegram-notify.bot-token",
                    type: "text",
                    placeholder: "Telegram Bot Token"
                })
                .registerSetting({
                    label: a().translator.trans("telegram-notify.admin.settings.chat-id.label"),
                    setting: "telegram-notify.chat-id",
                    type: "text",
                    placeholder: "Telegram Chat ID"
                })
                .registerSetting({
                    label: a().translator.trans("telegram-notify.admin.settings.message-format.label"),
                    setting: "telegram-notify.message-format",
                    type: "textarea",
                    placeholder: "{title} - {link}"
                })
                .registerSetting({
                    label: a().translator.trans("telegram-notify.admin.settings.button-text.label"),
                    setting: "telegram-notify.button-text",
                    type: "text",
                    placeholder: "Read More"
                });
        });
    })(), module.exports = n;
})();
