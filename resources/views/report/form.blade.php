<!--
    報告用フォーム
    dashboard の various ページのリンクから移動
 -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            報告
        </h2>
    </x-slot>

    <div class="container">
        <div class="py-12 col-lg-4 col-md-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                        <form id="report_form_form">
                            <label class="form-label">どのような内容ですか</label>
                            <div class="mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="report_form_radio_1_1"
                                        name="radio_1" value="1">
                                    <label class="form-check-label" for="report_form_radio_1_1">不快なコンテンツ</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="report_form_radio_1_2"
                                        name="radio_1" value="2">
                                    <label class="form-check-label" for="report_form_radio_1_2">嫌がらせ，いじめ</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="report_form_radio_1_3"
                                        name="radio_1" value="3">
                                    <label class="form-check-label" for="report_form_radio_1_3">権利の侵害</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="report_form_radio_1_4"
                                        name="radio_1" value="4">
                                    <label class="form-check-label" for="report_form_radio_1_4">スパムまたは誤解を招く内容</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="report_form_radio_1_5"
                                        name="radio_1" value="5">
                                    <label class="form-check-label" for="report_form_radio_1_5">掲示板サイトのバグ・脆弱性</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="report_form_radio_1_6"
                                        name="radio_1" value="6">
                                    <label class="form-check-label" for="report_form_radio_1_6">その他</label>
                                </div>
                                <div name="radio_1_error"></div>
                            </div>

                            <div class="mb-2">
                                <label for="report_form_textarea" class="form-label">内容を詳しく説明して下さい</label>
                                <textarea id="report_form_textarea" name="report_form_textarea"
                                    class="form-control"></textarea>
                                <div name="textarea_error"></div>
                            </div>
                        </form>
                        <button id="report_form_btn" class="btn btn-primary">
                            送信
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app_jquery.js') }}"></script>
</x-app-layout>
