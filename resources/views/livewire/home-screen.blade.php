<x-layout>
    <div>
        <article class="w-full bg-white flex-col gap-7 mt-24">
            <section class="BackGroundImageFirsSection">
                <aside class="topSection">
                    <h1 class="HeaderBooking">احـجــز فرحـــك لأن</h1>
                    <div class="descriptionText">
                        نحول مناسباتكم إلى لحظات لا تٌنسى سهولة الحجز عبر موقعنا تضمن لكم تجربة سلسة و ممتعة ابدأ الأن واختر قاعتك المثالية ليومك المميز
                    </div>
                    <div class="startButton">
                        <span class="StartButtonText">الـــبــــدء</span>
                        <i class="fa-solid fa-arrow-left-long"></i>
                    </div>

                </aside>
            </section>

            <section class="citiesSection">
                <aside class="citiesTextSection">
                    <div class="PopularCitiesFlexText">
                        <h1 class="PopularCitiesText">الـــمـــدن الــرائـــجـــة</h1>
                        <i class="fa-solid fa-arrow-left-long"></i>
                    </div>
                    <div class="popularOptionsText">الخـيارات الأكثر رواجاً للعملاء</div>
                </aside>
                <aside class="citiescardSection">
                             </aside>
            </section>

            <section class="popularHalls">
                <aside class="topSectionInPopularHalls">
                    <h1 class="popularHallsHeader">الــعــروض الاكــثــر طـلـبـاً</h1>
                    <img src="{{ asset('images/cities_images/ring.png') }}" alt="ring" class="ringImage" />
                </aside>
                <aside class="MiddleSectionInPopularHalls">
                    <div class="HallFrameContainerHomeScreen">

                    </div>
                    <div class="HallFrameContainerHomeScreen">

                    </div>
                    <div class="HallFrameContainerHomeScreen">

                    </div>
                </aside>
            </section>

            <section class="LastSectionSalle">
                <div class="TextSectionInSallSection">
                    <h3 class="sallText">تخــفيضــات تــصـل</h3>
                    <h3 class="sallText">50% - 70%</h3>
                </div>
                <div class="imageSectionInSallSection"></div>
                <div class="ShowMordeButtonInSallSection">
                    <button wire:click="handelPonudePopustaScreen" class="ShowMordeButton">مشاهدة الــعــروض</button>
                </div>
            </section>
        </article>
    </div>
</x-layout>
