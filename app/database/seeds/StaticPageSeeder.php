<?php
	class StaticPageSeeder extends Seeder
	{
		// This function creates the following pages:
		// About Us Page
		// Corporation Page
		// Contact Us Page
		// Blog
		// News
		// Some blog categories
		public function run()
		{
			DB::table('cms_pages')->truncate();
			DB::table('cms_articles')->truncate();
			DB::table('cms_pages_has_articles')->truncate();

			$blogPage = new CmsPage;
			// ONLY DO CHANGE with the parent_id of $blogCategoryPages on line around 94
			// blogPage->id = 1;
			$blogPage->parent_id = 0;
			$blogPage->name = "Blog";
			$blogPage->sort_order = 1;
			$blogPage->published_on = date("Y-m-d H:i:s");
			$blogPage->save();
			
			$newsPage = new CmsPage;
			$newsPage->name = "Haberler";
			$newsPage->sort_order = 2;
			$newsPage->published_on = date("Y-m-d H:i:s");
			$newsPage->save();

			$blogCategoryPages = array();
			$exampleNewsList = array();

			$pages = array(
				'İletişim'	 => 5,
				'Hakkımızda' => 4,
				'Kurumsal'	 => 3,
			);

			$page = new CmsPage;
			$page->parent_id = 0;
			$page->name = 'İletişim';
			$page->sort_order = 5;
			$page->published_on = date("Y-m-d H:i:s");			
			if($page->save())
			{
				$article = new CmsArticle;
				$article->title = 'İletişim Bilgileri';
				$article->summary = "";
				$article->content = ' <div class="maps">
					                        <iframe width="350" height="270" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=tr&amp;geocode=&amp;q=epigra&amp;ie=UTF8&amp;hq=epigra&amp;hnear=&amp;ll=41.114101,29.023303&amp;spn=0.006295,0.006295&amp;t=m&amp;output=embed"></iframe>
					                  </div>
					                  <div class="contact">
					                        <h3>Kasguru Aksesuar LTD.ŞRK</h3>
					                        <address>
					                              <div class="line">
					                                    <div class="address-box">
					                                          Adress
					                                    </div>
					                                    <div class="address-content-box">
					                                          : Ahi Evran caddesi Nazmi Akbacı iş merkezi No:57 Maslak
					                                    </div>
					                              </div>
					                              <div class="line">
					                                    <div class="address-box">
					                                          Telefon
					                                    </div>
					                                    <div class="address-content-box">
					                                          : 0539 000 00 00
					                                    </div>
					                              </div>
					                              <div class="line">
					                                    <div class="address-box">
					                                          Faks
					                                    </div>
					                                    <div class="address-content-box">
					                                          : 0539 000 00 00
					                                    </div>
					                              </div>
					                              <div class="line">
					                                    <div class="address-box">
					                                          Faks
					                                    </div>
					                                    <div class="address-content-box">
					                                          : 0539 000 00 00
					                                    </div>
					                              </div>
					                        </address>
					                        <div class="form">
					                              <h4>İletişim Formu</h4>
					                              <form method="POST">
					                                    <input type="text" name="full_name" class="form-control full_name"  placeholder="   Ad ve soyad" required>
					                                    <input type="text" name="phone" class="form-control phone"  placeholder="   Telefon">
					                                    <textarea name="comment" placeholder="   Mesajınız" class="form-control"></textarea>
					                                    <button type="submit" class="form-control pull-right">Gönder</button>
					                              </form>
					                        </div>

					                  </div>
					                   <div class="left-image">
					                              
					                  </div>
						           	';
				$article->published_on = date("Y-m-d H:i:s");
				$article->save();
				$page->articles()->attach($article->id , array('sort_order' => 3));
			}

			$page = new CmsPage;
			$page->parent_id = 0;
			$page->name = 'Hakkımızda';
			$page->sort_order = 4;
			$page->published_on = date("Y-m-d H:i:s");			
			if($page->save())
			{
				$article = new CmsArticle;
				$article->title = 'Hakkımızda';
				$article->summary = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
											Aliquam in leo dignissim, imperdiet est et, ullamcorper sem. 
											Nullam laoreet quam sodales ligula vulputate hendrerit sed id orci. 
											Proin mollis rutrum augue nec volutpat. ";
				$article->content = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
											Sed porta accumsan est non fringilla. Vivamus lorem mi, dictum ac risus eget, 
											commodo tempor mi. Aliquam tempus sem sit amet risus dapibus ullamcorper. Praesent 
											fermentum sem id eros pharetra, quis scelerisque eros commodo. Curabitur 
											laoreet nec augue vitae ullamcorper. Fusce tempus, nisl quis congue aliquam, 
											magna ipsum congue diam, id dapibus nisi arcu eget sapien. Cras gravida eros erat, 
											sodales condimentum neque ultrices et. Suspendisse justo turpis, porta volutpat nisi vel, 
											tristique tincidunt tellus. Praesent non cursus massa, sit amet vehicula urna. Vivamus tempus 
											sit amet tellus nec condimentum. Proin cursus lacus ac est mattis, vel convallis nisl tempus. 
											Vivamus a tortor tristique turpis feugiat lobortis ut at massa. Nunc facilisis varius sem, 
											nec scelerisque sem eleifend at.

											Proin quis condimentum mi, non consequat felis. Sed sodales sodales lacinia. 
											Integer posuere sed leo at pretium. Aliquam erat volutpat. Fusce eu sagittis dui. 
											Suspendisse dignissim tortor vitae lobortis faucibus. Aliquam tempor in nulla sit amet 
											rutrum. Morbi adipiscing nibh nec purus luctus bibendum. Etiam cursus velit velit, 
											eget mollis leo condimentum ut. Suspendisse egestas mi tortor, vel convallis dui 
											condimentum vel. Phasellus at nisl pellentesque odio lacinia varius a quis nulla. 
											Praesent sit amet faucibus nulla. Etiam pellentesque rutrum convallis. Phasellus non magna 
											justo. Aenean a tincidunt libero. Aenean eget sem ac sapien lacinia lobortis.

											In viverra a nisl et dictum. Maecenas pellentesque bibendum consectetur. Vivamus 
											a enim vel urna ornare auctor vel vel tellus. Nunc commodo sollicitudin ligula, 
											sed varius nulla aliquam id. Etiam id diam sit amet arcu gravida pharetra non ut erat. 
											Sed tempus congue nulla, nec sodales felis varius et. Sed ut tincidunt urna. Suspendisse 
											non libero in lacus tempor dictum sed non neque. Nunc iaculis tortor eu dolor interdum, 
											ut dignissim ligula porttitor. ";
				$article->published_on = date("Y-m-d H:i:s");
				$article->save();
				$page->articles()->attach($article->id , array('sort_order' => 4));
			}

			$page = new CmsPage;
			$page->parent_id = 0;
			$page->name = 'Kurumsal';
			$page->sort_order = 3;
			$page->published_on = date("Y-m-d H:i:s");			
			if($page->save())
			{
				$article = new CmsArticle;
				$article->title = 'Kurumsal';
				$article->summary = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
											Aliquam in leo dignissim, imperdiet est et, ullamcorper sem. 
											Nullam laoreet quam sodales ligula vulputate hendrerit sed id orci. 
											Proin mollis rutrum augue nec volutpat. ";
				$article->content = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
											Sed porta accumsan est non fringilla. Vivamus lorem mi, dictum ac risus eget, 
											commodo tempor mi. Aliquam tempus sem sit amet risus dapibus ullamcorper. Praesent 
											fermentum sem id eros pharetra, quis scelerisque eros commodo. Curabitur 
											laoreet nec augue vitae ullamcorper. Fusce tempus, nisl quis congue aliquam, 
											magna ipsum congue diam, id dapibus nisi arcu eget sapien. Cras gravida eros erat, 
											sodales condimentum neque ultrices et. Suspendisse justo turpis, porta volutpat nisi vel, 
											tristique tincidunt tellus. Praesent non cursus massa, sit amet vehicula urna. Vivamus tempus 
											sit amet tellus nec condimentum. Proin cursus lacus ac est mattis, vel convallis nisl tempus. 
											Vivamus a tortor tristique turpis feugiat lobortis ut at massa. Nunc facilisis varius sem, 
											nec scelerisque sem eleifend at.

											Proin quis condimentum mi, non consequat felis. Sed sodales sodales lacinia. 
											Integer posuere sed leo at pretium. Aliquam erat volutpat. Fusce eu sagittis dui. 
											Suspendisse dignissim tortor vitae lobortis faucibus. Aliquam tempor in nulla sit amet 
											rutrum. Morbi adipiscing nibh nec purus luctus bibendum. Etiam cursus velit velit, 
											eget mollis leo condimentum ut. Suspendisse egestas mi tortor, vel convallis dui 
											condimentum vel. Phasellus at nisl pellentesque odio lacinia varius a quis nulla. 
											Praesent sit amet faucibus nulla. Etiam pellentesque rutrum convallis. Phasellus non magna 
											justo. Aenean a tincidunt libero. Aenean eget sem ac sapien lacinia lobortis.

											In viverra a nisl et dictum. Maecenas pellentesque bibendum consectetur. Vivamus 
											a enim vel urna ornare auctor vel vel tellus. Nunc commodo sollicitudin ligula, 
											sed varius nulla aliquam id. Etiam id diam sit amet arcu gravida pharetra non ut erat. 
											Sed tempus congue nulla, nec sodales felis varius et. Sed ut tincidunt urna. Suspendisse 
											non libero in lacus tempor dictum sed non neque. Nunc iaculis tortor eu dolor interdum, 
											ut dignissim ligula porttitor. ";
				$article->published_on = date("Y-m-d H:i:s");
				$article->save();
				$page->articles()->attach($article->id , array('sort_order' => 5));
			}

			$page = new CmsPage;
			$page->parent_id = 0;
			$page->name = 'Gizlilik Politikası';
			$page->sort_order = 6;
			$page->published_on = date("Y-m-d H:i:s");			
			if($page->save())
			{
				$article = new CmsArticle;
				$article->title = 'Gizlilik Politikası';
				$article->summary = "";
				$article->content = 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.';
				$article->published_on = date("Y-m-d H:i:s");
				$article->save();
				$page->articles()->attach($article->id , array('sort_order' => 1));
			}

			$page = new CmsPage;
			$page->parent_id = 0;
			$page->name = 'Kullanıcı Sözleşmesi';
			$page->sort_order = 7;
			$page->published_on = date("Y-m-d H:i:s");			
			if($page->save())
			{
				$article = new CmsArticle;
				$article->title = 'Kullanıcı Sözleşmesi';
				$article->summary = "";
				$article->content = 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.';
				$article->published_on = date("Y-m-d H:i:s");
				$article->save();
				$page->articles()->attach($article->id , array('sort_order' => 1));
			}

			$page = new CmsPage;
			$page->parent_id = 0;
			$page->name = 'Sıkça Sorulan Sorular';
			$page->sort_order = 8;
			$page->published_on = date("Y-m-d H:i:s");			
			if($page->save())
			{
				$article = new CmsArticle;
				$article->title = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
				$article->summary = "";
				$article->content = 'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven\'t heard of them accusamus labore sustainable VHS.
						           	';
				$article->published_on = date("Y-m-d H:i:s");
				$article->save();
				$page->articles()->attach($article->id , array('sort_order' => 1));
			}

			

		}
	}
/** End of StaticPageSeeder.php */
