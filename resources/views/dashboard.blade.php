<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Top page')}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                    <div class="flex items-center">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="ml-4 text-lg leading-7 font-semibold"><a href="{{ url('hub') }}" class="underline text-gray-900 dark:text-white">掲示板</a></div>
                    </div>

                    <div class="ml-12">
                        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                            HxSコンピュータ部が提供する掲示板です．利用には学内ネットワーク・ログインが必要です．
                        </div>
                    </div>
                </div>


                <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                    <div class="flex items-center">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="ml-4 text-lg leading-7 font-semibold"><a href="https://twitter.com/hxs_" target="_blank" class="underline text-gray-900 dark:text-white">Twitter</a></div>
                    </div>

                    <div class="ml-12">
                        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                            大阪工業大学 HxSコンピュータ部の非公式アカウントです。ハードウェア（Hardware）とソフトウェア（Software）の両面からスキルアップを図る事を目標とした部活です。活動内容・イベント宣伝等をつぶやきます。
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                    <div class="flex items-center">
                        <!-- よさげなアイコン
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        -->
                        <div class="ml-4 text-lg leading-7 font-semibold">アクセスランキング</div>
                    </div>

                    <div class="ml-12">
                        <?php
                            $count = 1;
                        ?>
                        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                        <table class="table table-striped">
							<thead>
								<tr><th>{{__('Access Ranking')}}</th><td>{{__('Access count')}}</td><td>{{__('Thread name')}}</td></tr>
							</thead>
							<tbody>
                            @foreach($access_ranking as $row)
                                    <?php
                                        $title = str_replace("&amp;slash;", "/", $row['thread_name']);
                                        $title = str_replace("&amp;backSlash;", "\\", $title);
                                    ?>
                                    <tr><th>{{ $count++ }}</th><td>{{ $row['access_count'] }}</td><td>{{ $title }}</td></tr>
                            @endforeach
                            </tbody>
						</table>
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                    <div class="flex items-center">
                        <!-- よさげなアイコン
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        -->
                        <div class="ml-4 text-lg leading-7 font-semibold"><a href="https://github.com/oithxs" target="_blank" class="underline text-gray-900 dark:text-white">Github</a></div>
                    </div>

                    <div class="ml-12">
                        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                            大阪工業大学情報科学部HxSコンピュータ部の組織アカウントです。
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>
