@extends('layouts.front')

@section('title', 'Anasayfa - Trunçgil Teknoloji')

@section('content')
<section class="wrapper !bg-[#f0f0f8]">
    <div class="container pt-10 lg:pt-14 xl:!pt-14 xxl:!pt-10 lg:pb-10 xl:pb-10 xxl:pb-0">
        <div class="flex flex-wrap mx-[-15px] md:mx-[-20px] lg:mx-[-20px] xl:mx-[-35px] !mt-[-50px] items-center text-center lg:text-left xl:text-left">
            <div class="lg:w-6/12 xl:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full md:!px-[20px] lg:!px-[20px] xl:!px-[35px] !mt-[50px]" data-cues="slideInDown" data-group="page-title" data-delay="900">
                <h1 class="xl:!text-[2.5rem] !text-[calc(1.375rem_+_1.5vw)] !leading-[1.15] font-semibold !mb-4 xl:!mr-5 xl:!mt-[-2.5rem] lg:!mt-[-2.5rem]">İşinizi Büyütün <br class="hidden md:block xl:!hidden lg:!hidden"><span class="!text-[#e31e24]">Pazarlama Çözümlerimizle</span></h1>
                <p class="lead !text-[1.2rem] !leading-[1.5] !mb-7 xxl:!pr-20">Müşterilerimizin web sitesi trafiğini, sıralamasını ve görünürlüğünü artırmalarına yardımcı oluyoruz.</p>
                <div class="inline-flex !mr-2"><a href="#" class="btn btn-lg btn-grape !text-white !bg-[#e31e24] border-[#e31e24] hover:text-white hover:bg-[#e31e24] hover:!border-[#e31e24] active:text-white active:bg-[#e31e24] active:border-[#e31e24] disabled:text-white disabled:bg-[#e31e24] disabled:border-[#e31e24] rounded">Ücretsiz Dene</a></div>
                <div class="inline-flex"><a href="#" class="btn btn-lg btn-outline-grape !text-[#e31e24] bg-[#e31e24] !border-[#e31e24] !border-[2px] hover:!text-white hover:!bg-[#e31e24] hover:!border-[#e31e24] focus:shadow-[rgba(96,93,186,1)] active:!text-white active:bg-[#e31e24] active:border-[#e31e24] disabled:!text-white disabled:bg-transparent disabled:border-[#e31e24] rounded">Keşfet</a></div>
            </div>
            <!--/column -->
            <div class="w-10/12 md:w-7/12 lg:w-6/12 xl:w-5/12 !mx-auto flex-[0_0_auto] !px-[15px] max-w-full xl:!ml-5 md:!px-[20px] lg:!px-[20px] xl:!px-[35px] !mt-[50px]">
                <img class="max-w-full h-auto !mb-[-3.5rem] md:!mb-[-4.5rem] lg:!mb-[-9rem] xl:!mb-[-9rem]" src="{{ asset('html/assets/img/illustrations/3d11.png') }}" data-cue="fadeIn" data-delay="300" alt="image">
            </div>
            <!--/column -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
    <figure class="m-0 p-0"><img class="w-full max-w-full !h-auto" src="{{ asset('html/assets/img/photos/clouds.png') }}" alt="image"></figure>
</section>
<!-- /section -->

<section class="wrapper bg-[rgba(255,255,255)] opacity-100">
    <div class="container pt-20 pb-20 xl:pb-28 lg:pb-28 md:pb-28">
        <div class="flex flex-wrap mx-[-15px] !text-center">
            <div class="md:w-10/12 md:!ml-[8.33333333%] lg:w-10/12 lg:!ml-[8.33333333%] xl:w-10/12 xl:!ml-[8.33333333%] xxl:w-8/12 xxl:!ml-[16.66666667%] flex-[0_0_auto] !px-[15px] max-w-full">
                <h2 class="!text-[0.8rem] uppercase !text-[#e31e24] !mb-3 !leading-[1.35] !tracking-[0.02rem]">Ne Yapıyoruz?</h2>
                <h3 class="xl:!text-[1.9rem] !text-[calc(1.315rem_+_0.78vw)] !leading-[1.25] font-semibold !mb-9">Sunduğumuz tam hizmet, işletmenizin ihtiyaçlarını karşılamak için özel olarak tasarlanmıştır.</h3>
            </div>
            <!-- /column -->
        </div>
        <!-- /.row -->
        <div class="flex flex-wrap mx-[-15px] xl:mx-[-20px] lg:mx-[-20px] md:mx-[-20px] !mt-[-40px] !mb-20 xl:!mb-[7rem] lg:!mb-[7rem] md:!mb-[7rem] !text-center">
            <!-- Hizmet 1 -->
            <div class="md:w-6/12 lg:w-3/12 xl:w-3/12 w-full flex-[0_0_auto] !px-[15px] xl:!px-[20px] lg:!px-[20px] md:!px-[20px] !mt-[40px] max-w-full">
                <div class="md:!px-3 lg:!px-0 xl:!px-3">
                    <img src="{{ asset('html/assets/img/icons/solid/globe-2.svg') }}" class="svg-inject icon-svg icon-svg-md !w-[2.6rem] !h-[2.6rem] solid-mono text-[#e31e24] text-grape !mb-5 m-[0_auto]" alt="" />
                    <h4>SEO Hizmetleri</h4>
                    <p class="!mb-2">Web sitenizin görünürlüğünü artırmak için profesyonel SEO hizmetleri sunuyoruz.</p>
                    <a href="#" class="more hover !text-[#e31e24]">Daha Fazla</a>
                </div>
            </div>
            <!-- Hizmet 2 -->
            <div class="md:w-6/12 lg:w-3/12 xl:w-3/12 w-full flex-[0_0_auto] !px-[15px] xl:!px-[20px] lg:!px-[20px] md:!px-[20px] !mt-[40px] max-w-full">
                <div class="md:!px-3 lg:!px-0 xl:!px-3">
                    <img src="{{ asset('html/assets/img/icons/solid/code.svg') }}" class="svg-inject icon-svg icon-svg-md !w-[2.6rem] !h-[2.6rem] solid-mono text-[#e31e24] text-grape !mb-5 m-[0_auto]" alt="" />
                    <h4>Web Tasarım</h4>
                    <p class="!mb-2">Modern ve kullanıcı dostu web tasarımları ile markanızı öne çıkarın.</p>
                    <a href="#" class="more hover !text-[#e31e24]">Daha Fazla</a>
                </div>
            </div>
            <!-- Hizmet 3 -->
            <div class="md:w-6/12 lg:w-3/12 xl:w-3/12 w-full flex-[0_0_auto] !px-[15px] xl:!px-[20px] lg:!px-[20px] md:!px-[20px] !mt-[40px] max-w-full">
                <div class="md:!px-3 lg:!px-0 xl:!px-3">
                    <img src="{{ asset('html/assets/img/icons/solid/team.svg') }}" class="svg-inject icon-svg icon-svg-md !w-[2.6rem] !h-[2.6rem] solid-mono text-[#e31e24] text-grape !mb-5 m-[0_auto]" alt="" />
                    <h4>Sosyal Medya</h4>
                    <p class="!mb-2">Sosyal medya yönetimi ile hedef kitlenizle etkileşimi artırın.</p>
                    <a href="#" class="more hover !text-[#e31e24]">Daha Fazla</a>
                </div>
            </div>
            <!-- Hizmet 4 -->
            <div class="md:w-6/12 lg:w-3/12 xl:w-3/12 w-full flex-[0_0_auto] !px-[15px] xl:!px-[20px] lg:!px-[20px] md:!px-[20px] !mt-[40px] max-w-full">
                <div class="md:!px-3 lg:!px-0 xl:!px-3">
                    <img src="{{ asset('html/assets/img/icons/solid/devices.svg') }}" class="svg-inject icon-svg icon-svg-md !w-[2.6rem] !h-[2.6rem] solid-mono text-[#e31e24] text-grape !mb-5 m-[0_auto]" alt="" />
                    <h4>Uygulama Geliştirme</h4>
                    <p class="!mb-2">iOS ve Android için özel mobil uygulamalar geliştiriyoruz.</p>
                    <a href="#" class="more hover !text-[#e31e24]">Daha Fazla</a>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <!-- Features/Why Choose Us Section -->
        <div class="flex flex-wrap mx-[-7.5px] !mt-[-50px] !mb-[4.5rem] xl:!mb-[6rem] lg:!mb-[6rem] md:!mb-[6rem] items-center">
            <div class="xl:w-6/12 lg:w-6/12 w-full flex-[0_0_auto] max-w-full px-[7.5px] !mt-[50px]">
                <figure class="m-0 p-0"><img class="w-auto" src="{{ asset('html/assets/img/illustrations/3d8.png') }}" alt="image"></figure>
            </div>
            <div class="xl:w-5/12 lg:w-5/12 w-full flex-[0_0_auto] max-w-full !ml-auto px-[7.5px] !mt-[50px]">
                <h2 class="!text-[0.8rem] uppercase !text-[#e31e24] !mb-3 !leading-[1.35] !tracking-[0.02rem]">Neden Bizi Seçmelisiniz?</h2>
                <h3 class="xl:!text-[1.9rem] !text-[calc(1.315rem_+_0.78vw)] !leading-[1.25] font-semibold !mb-8">Değerli müşterilerimizin bizi tercih etmesinin birkaç nedeni.</h3>
                
                <div class="flex flex-wrap mx-[-15px] !mt-[-30px]">
                    <div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mt-[30px]">
                        <div class="flex flex-row">
                            <div>
                                <img src="{{ asset('html/assets/img/icons/solid/lamp.svg') }}" class="svg-inject icon-svg !w-[1.8rem] !h-[1.8rem] solid-mono text-[#e31e24] text-grape !mr-4" alt="" />
                            </div>
                            <div>
                                <h4 class="!mb-1">Yaratıcılık</h4>
                                <p class="!mb-0">Özgün ve yaratıcı çözümler.</p>
                            </div>
                        </div>
                    </div>
                    <div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mt-[30px]">
                        <div class="flex flex-row">
                            <div>
                                <img src="{{ asset('html/assets/img/icons/solid/bulb.svg') }}" class="svg-inject icon-svg !w-[1.8rem] !h-[1.8rem] solid-mono text-[#e31e24] text-grape !mr-4" alt="" />
                            </div>
                            <div>
                                <h4 class="!mb-1">Yenilikçi Düşünce</h4>
                                <p class="!mb-0">Geleceği şekillendiren fikirler.</p>
                            </div>
                        </div>
                    </div>
                    <div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mt-[30px]">
                        <div class="flex flex-row">
                            <div>
                                <img src="{{ asset('html/assets/img/icons/solid/puzzle.svg') }}" class="svg-inject icon-svg !w-[1.8rem] !h-[1.8rem] solid-mono text-[#e31e24] text-grape !mr-4" alt="" />
                            </div>
                            <div>
                                <h4 class="!mb-1">Hızlı Çözümler</h4>
                                <p class="!mb-0">Zamanında teslimat ve hızlı destek.</p>
                            </div>
                        </div>
                    </div>
                    <div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mt-[30px]">
                        <div class="flex flex-row">
                            <div>
                                <img src="{{ asset('html/assets/img/icons/solid/headphone.svg') }}" class="svg-inject icon-svg !w-[1.8rem] !h-[1.8rem] solid-mono text-[#e31e24] text-grape !mr-4" alt="" />
                            </div>
                            <div>
                                <h4 class="!mb-1">Üstün Destek</h4>
                                <p class="!mb-0">7/24 müşteri memnuniyeti odaklı destek.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Solutions & Pricing Section (NEW) -->
        <div class="flex flex-wrap mx-[-7.5px] !mt-[-50px] xl:!mt-0 lg:!mt-0 !mb-20 xl:!mb-[7rem] lg:!mb-[7rem] md:!mb-[7rem] items-center">
            <div class="xl:w-5/12 lg:w-5/12 w-full flex-[0_0_auto] max-w-full !mx-auto xl:!order-2 lg:!order-2 px-[7.5px] !mt-[50px] xl:!mt-0 lg:!mt-0">
                <figure class="m-0 p-0"><img class="w-auto" src="{{ asset('html/assets/img/illustrations/3d5.png') }}" alt="image"></figure>
            </div>
            <div class="xl:w-5/12 lg:w-5/12 w-full flex-[0_0_auto] max-w-full !mr-auto px-[7.5px] !mt-[50px] xl:!mt-0 lg:!mt-0">
                <h2 class="!text-[0.8rem] uppercase !text-[#e31e24] !mb-3 !leading-[1.35] !tracking-[0.02rem] !mb-3">Çözümlerimiz</h2>
                <h3 class="xl:!text-[1.9rem] !text-[calc(1.315rem_+_0.78vw)] !leading-[1.25] font-semibold !mb-5 xxl:!pr-5">Siz arkanıza yaslanın, iş ihtiyaçlarınızı biz halledelim.</h3>
                <p class="!mb-6">Yaratıcı ve yenilikçi çözümlerimizle işletmenizi dijital dünyada öne çıkarıyoruz. Sektördeki deneyimimiz ve uzman ekibimizle, hedeflerinize ulaşmanız için yanınızdayız.</p>
                <div class="flex flex-wrap mx-[-15px] items-center counter-wrapper !mt-[-30px]">
                    <div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mt-[30px]">
                        <h3 class="counter counter-lg !text-[calc(1.345rem_+_1.14vw)] !tracking-[normal] !leading-none xl:!text-[2.2rem] !mb-1">99.7%</h3>
                        <h6 class="!text-[0.85rem] !mb-1">Müşteri Memnuniyeti</h6>
                        <span class="ratings inline-block relative w-20 h-[0.8rem] text-[0.9rem] leading-none before:text-[rgba(38,43,50,0.1)] after:inline-block after:not-italic after:font-normal after:absolute after:!text-[#fcc032] after:content-['\2605\2605\2605\2605\2605'] after:overflow-hidden after:left-0 after:top-0 before:inline-block before:not-italic before:font-normal before:absolute before:!text-[#fcc032] before:content-['\2605\2605\2605\2605\2605'] before:overflow-hidden before:left-0 before:top-0 five"></span>
                    </div>
                    <div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mt-[30px]">
                        <h3 class="counter counter-lg !text-[calc(1.345rem_+_1.14vw)] !tracking-[normal] !leading-none xl:!text-[2.2rem] !mb-1">4x</h3>
                        <h6 class="!text-[0.85rem] !mb-1">Yeni Ziyaretçi</h6>
                        <span class="ratings inline-block relative w-20 h-[0.8rem] text-[0.9rem] leading-none before:text-[rgba(38,43,50,0.1)] after:inline-block after:not-italic after:font-normal after:absolute after:!text-[#fcc032] after:content-['\2605\2605\2605\2605\2605'] after:overflow-hidden after:left-0 after:top-0 before:inline-block before:not-italic before:font-normal before:absolute before:!text-[#fcc032] before:content-['\2605\2605\2605\2605\2605'] before:overflow-hidden before:left-0 before:top-0 five"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap mx-[-15px] !mt-[-30px] !mb-20 xl:!mb-[7rem] lg:!mb-[7rem] md:!mb-[7rem]">
            <div class="xl:w-4/12 lg:w-4/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mt-[30px]">
                <h2 class="!text-[0.8rem] uppercase !text-[#e31e24] !mb-3 !leading-[1.35] !tracking-[0.02rem] xl:!mt-[8rem] lg:!mt-[8rem]">Fiyatlandırma</h2>
                <h3 class="xl:!text-[1.9rem] !text-[calc(1.315rem_+_0.78vw)] !leading-[1.25] font-semibold !mb-3">Harika ve premium fiyatlar sunuyoruz.</h3>
                <p>30 günlük <a href="#" class="hover !text-[#e31e24]">ücretsiz deneme</a> ile tam hizmeti deneyimleyin. Kredi kartı gerekmez!</p>
                <a href="#" class="btn btn-grape !text-white !bg-[#e31e24] border-[#e31e24] hover:text-white hover:bg-[#e31e24] hover:!border-[#e31e24] active:text-white active:bg-[#e31e24] active:border-[#e31e24] disabled:text-white disabled:bg-[#e31e24] disabled:border-[#e31e24] rounded !mt-2">Tüm Fiyatları Gör</a>
            </div>
            <div class="xl:w-7/12 lg:w-7/12 w-full flex-[0_0_auto] !px-[15px] max-w-full xl:!ml-[8.33333333%] lg:!ml-[8.33333333%] pricing-wrapper !mt-[30px]">
                <div class="flex flex-wrap mx-[-15px] !mt-[25px] !relative">
                    <div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mt-[30px]">
                        <div class="pricing card !shadow-[0_0.25rem_1.75rem_rgba(30,34,40,0.07)] !border-[#cfceea] after:border-b-[calc(0.4rem_-_6px)] after:border-t-[6px] after:content-[''] after:absolute after:rounded-t-[0.4rem] after:border-t-inherit after:border-b-transparent after:top-0 after:inset-x-0">
                            <div class="card-body !p-[3rem_40px_3.5rem_40px]">
                                <div class="prices !text-[#343f52]">
                                    <div class="price price-show !justify-start"><span class="price-currency">₺</span><span class="price-value">499</span> <span class="price-duration">ay</span></div>
                                </div>
                                <h4 class="card-title !mt-2">Premium Paket</h4>
                                <ul class="pl-0 list-none bullet-bg bullet-soft-primary !mt-7 !mb-8">
                                    <li class="relative !pl-[1.25rem]"><i class="uil uil-check absolute left-0 text-[1.05rem] leading-none !tracking-[normal] !text-center flex items-center justify-center !text-[#e31e24] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i><span><strong>5</strong> Proje </span></li>
                                    <li class="relative !pl-[1.25rem] !mt-[0.35rem]"><i class="uil uil-check absolute left-0 text-[1.05rem] leading-none !tracking-[normal] !text-center flex items-center justify-center !text-[#e31e24] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i><span><strong>100K</strong> API Erişimi </span></li>
                                    <li class="relative !pl-[1.25rem] !mt-[0.35rem]"><i class="uil uil-check absolute left-0 text-[1.05rem] leading-none !tracking-[normal] !text-center flex items-center justify-center !text-[#e31e24] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i><span><strong>200MB</strong> Depolama </span></li>
                                    <li class="relative !pl-[1.25rem] !mt-[0.35rem]"><i class="uil uil-check absolute left-0 text-[1.05rem] leading-none !tracking-[normal] !text-center flex items-center justify-center !text-[#e31e24] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i><span> Haftalık <strong>Raporlar</strong></span></li>
                                </ul>
                                <a href="#" class="btn btn-grape !text-white !bg-[#e31e24] border-[#e31e24] hover:text-white hover:bg-[#e31e24] hover:!border-[#e31e24] active:text-white active:bg-[#e31e24] active:border-[#e31e24] disabled:text-white disabled:bg-[#e31e24] disabled:border-[#e31e24] !text-[.85rem] !rounded-[.4rem] hover:translate-y-[-0.15rem] hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,0.15)]">Seç</a>
                            </div>
                        </div>
                    </div>
                    <div class="xl:w-6/12 lg:w-6/12 md:w-6/12 w-full flex-[0_0_auto] !px-[15px] max-w-full popular !mt-[30px]">
                        <div class="pricing card !shadow-[0_0.25rem_1.75rem_rgba(30,34,40,0.07)] !border-[#cfceea] after:border-b-[calc(0.4rem_-_6px)] after:border-t-[6px] after:content-[''] after:absolute after:rounded-t-[0.4rem] after:border-t-inherit after:border-b-transparent after:top-0 after:inset-x-0">
                            <div class="card-body !p-[3rem_40px_3.5rem_40px]">
                                <div class="prices !text-[#343f52]">
                                    <div class="price price-show !justify-start"><span class="price-currency">₺</span><span class="price-value">1499</span> <span class="price-duration">ay</span></div>
                                </div>
                                <h4 class="card-title !mt-2">Kurumsal Paket</h4>
                                <ul class="pl-0 list-none bullet-bg bullet-soft-primary !mt-7 !mb-8">
                                    <li class="relative !pl-[1.25rem] !mt-[0.35rem]"><i class="uil uil-check absolute left-0 text-[1.05rem] leading-none !tracking-[normal] !text-center flex items-center justify-center !text-[#e31e24] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i><span><strong>20</strong> Proje </span></li>
                                    <li class="relative !pl-[1.25rem] !mt-[0.35rem]"><i class="uil uil-check absolute left-0 text-[1.05rem] leading-none !tracking-[normal] !text-center flex items-center justify-center !text-[#e31e24] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i><span><strong>300K</strong> API Erişimi </span></li>
                                    <li class="relative !pl-[1.25rem] !mt-[0.35rem]"><i class="uil uil-check absolute left-0 text-[1.05rem] leading-none !tracking-[normal] !text-center flex items-center justify-center !text-[#e31e24] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i><span><strong>500MB</strong> Depolama </span></li>
                                    <li class="relative !pl-[1.25rem] !mt-[0.35rem]"><i class="uil uil-check absolute left-0 text-[1.05rem] leading-none !tracking-[normal] !text-center flex items-center justify-center !text-[#e31e24] rounded-[100%] top-[0.2rem] before:content-['\e9dd'] before:align-middle before:table-cell"></i><span> 7/24 <strong>Destek</strong></span></li>
                                </ul>
                                <a href="#" class="btn btn-grape !text-white !bg-[#e31e24] border-[#e31e24] hover:text-white hover:bg-[#e31e24] hover:!border-[#e31e24] active:text-white active:bg-[#e31e24] active:border-[#e31e24] disabled:text-white disabled:bg-[#e31e24] disabled:border-[#e31e24] !text-[.85rem] !rounded-[.4rem] hover:translate-y-[-0.15rem] hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,0.15)]">Seç</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="flex flex-wrap mx-[-7.5px] !mt-[-50px] xl:!mt-0 lg:!mt-0 items-center">
            <div class="xl:w-6/12 lg:w-6/12 w-full flex-[0_0_auto] px-[7.5px] !mt-[50px] xl:!mt-0 lg:!mt-0 max-w-full">
                <figure class="m-0 p-0"><img class="w-auto" src="{{ asset('html/assets/img/illustrations/3d3.png') }}" alt="image"></figure>
            </div>
            <div class="xl:w-5/12 lg:w-5/12 w-full flex-[0_0_auto] px-[7.5px] !mt-[50px] xl:!mt-0 lg:!mt-0 max-w-full !ml-auto">
                <h2 class="!text-[0.8rem] uppercase !text-[#e31e24] !mb-3 !leading-[1.35] !tracking-[0.02rem]">Tanışalım</h2>
                <h3 class="xl:!text-[1.9rem] !text-[calc(1.315rem_+_0.78vw)] !leading-[1.25] font-semibold !mb-3">Birlikte harika işler başaralım. 5000+ müşterimiz bize güveniyor.</h3>
                <p>Projelerinizi hayata geçirmek, dijital dönüşümünüze katkıda bulunmak ve işinizi büyütmek için buradayız. Hemen bizimle iletişime geçin.</p>
                <a href="#" class="btn btn-grape !text-white !bg-[#e31e24] border-[#e31e24] hover:text-white hover:bg-[#e31e24] hover:!border-[#e31e24] active:text-white active:bg-[#e31e24] active:border-[#e31e24] disabled:text-white disabled:bg-[#e31e24] disabled:border-[#e31e24] rounded !mt-2">Bize Katılın</a>
            </div>
        </div>

    </div>
</section>

<section class="wrapper !bg-[#f0f0f8]">
    <div class="container py-[4.5rem] xl:!py-24 lg:!py-24 md:!py-24">
        <div class="flex flex-wrap mx-[-15px] !mb-8">
            <div class="xl:w-8/12 lg:w-8/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mx-auto !text-center">
                <h2 class="!text-[0.8rem] uppercase !text-[#e31e24] !mb-3 !leading-[1.35] !tracking-[0.02rem]">Şimdi Analiz Edin</h2>
                <h3 class="xl:!text-[1.9rem] !text-[calc(1.315rem_+_0.78vw)] !leading-[1.25] font-semibold !mb-0">Web sitenizin ne kadar hızlı olabileceğini merak ediyor musunuz? SEO Skorunuzu hemen kontrol edin.</h3>
            </div>
        </div>
        <div class="flex flex-wrap mx-[-15px]">
            <div class="xl:w-5/12 lg:w-5/12 w-full flex-[0_0_auto] !px-[15px] max-w-full !mx-auto">
                <form action="#">
                    <div class="form-floating input-group relative">
                        <input type="url" class="form-control border-0 relative block w-full text-[.75rem] font-medium !text-[#60697b] bg-[#fefefe] bg-clip-padding shadow-[0_0_1.25rem_rgba(30,34,40,0.04)] rounded-[0.4rem] duration-[0.15s] ease-in-out focus:shadow-[0_0_1.25rem_rgba(30,34,40,0.04),unset] placeholder:!text-[#959ca9] placeholder:opacity-100 m-0 !pr-9 p-[.6rem_1rem] h-[calc(2.5rem_+_2px)] min-h-[calc(2.5rem_+_2px)] !leading-[1.25]" placeholder="" id="analyze">
                        <label class="inline-block !text-[#959ca9] text-[.75rem] absolute z-[2] h-full overflow-hidden text-start text-ellipsis whitespace-nowrap pointer-events-none border origin-[0_0] px-4 py-[0.6rem] border-solid border-transparent left-0 top-0 font-Manrope" for="analyze">Web Sitesi URL Girin</label>
                        <button class="btn btn-grape !text-white !bg-[#e31e24] border-[#e31e24] hover:text-white hover:bg-[#e31e24] hover:!border-[#e31e24] active:text-white active:bg-[#e31e24] active:border-[#e31e24] disabled:text-white disabled:bg-[#e31e24] disabled:border-[#e31e24] hover:shadow-[0_0.25rem_0.75rem_rgba(30,34,40,0.15)] hover:!translate-none" type="button">Analiz Et</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <figure class="m-0 p-0"><img class="w-full max-w-full !h-auto" src="{{ asset('html/assets/img/photos/clouds.png') }}" alt="image"></figure>
</section>
@endsection
