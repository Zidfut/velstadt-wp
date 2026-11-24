document.addEventListener('DOMContentLoaded', () => {

	const security = document.querySelector('.section.security');
	if (security && 'IntersectionObserver' in window) {
		const securityObserver = new IntersectionObserver((entries) => {
			if (entries.some((entry) => entry.isIntersecting)) {
				security.classList.add('security--expanded');
				securityObserver.disconnect();
			}
		}, { rootMargin: '0px 0px -100px 0px' });

		securityObserver.observe(security);
	}

	const menuBtn = document.querySelector('.header__mobile-btn');
	const headerMenu = document.querySelector('.header__nav-wrap');
	const body = document.querySelector('body');

	if (menuBtn && headerMenu) {
		menuBtn.addEventListener('click', () => {
			const isOpen = menuBtn.classList.toggle('active');

			headerMenu.classList.toggle('active', isOpen);
			body.classList.toggle('no-scroll', isOpen);
			menuBtn.setAttribute('aria-expanded', String(isOpen));
		});
	}
	
	const dropdownMedia = window.matchMedia('(max-width: 1200px)');

	document.querySelectorAll('.dropdown__btn').forEach((button) => {
		button.addEventListener('click', function (event) {
			if (!dropdownMedia.matches) {
				return;
			}

			event.preventDefault();
			event.stopPropagation();

			const currentDropdown = this.closest('.dropdown');

			document.querySelectorAll('.dropdown.active').forEach((dropdown) => {
				if (dropdown !== currentDropdown) {
					dropdown.classList.remove('active');
					dropdown.querySelector('.dropdown__btn').classList.remove('active');
					dropdown.querySelector('.dropdown__btn').setAttribute('aria-expanded', 'false');
				}
			});

			const isOpen = currentDropdown.classList.toggle('active');
			this.classList.toggle('active', isOpen);
			this.setAttribute('aria-expanded', String(isOpen));
		});
	});

	const partnersSwiper = new Swiper(".partners__swiper", {
		slidesPerView: "auto",
		spaceBetween: 48,
		loop: true,
		speed: 6000,
		allowTouchMove: false,
		autoplay: {
			delay: 1,
			disableOnInteraction: false
		},
		breakpoints: {
			320: {
				spaceBetween: 32,
			},
			768: {
				spaceBetween: 48,
			},
			1200: {
				spaceBetween: 60,
			},
		}
	});

	const resourcesSwiper = new Swiper(".resources__swiper", {
		slidesPerView: 'auto',
		spaceBetween: 0,
		breakpoints: {
			576: {
				slidesPerView: 2,
			},
			768: {
				slidesPerView: 'auto',
			},
			1024: {
				slidesPerView: 3,
			},
		}
	});

	const relatedSwiper = new Swiper(".related__swiper", {
		slidesPerView: 'auto',
		spaceBetween: 16,
		breakpoints: {
			576: {
				slidesPerView: 2,
				spaceBetween: 16,
			},
			1024: {
				slidesPerView: 3,
				spaceBetween: 24,
			},
		}
	});

	const customerSwiper = new Swiper(".customer__swiper", {
		slidesPerView: 'auto',
		spaceBetween: 16,
		breakpoints: {
			576: {
				slidesPerView: 2,
			},
			768: {
				slidesPerView: 'auto',
				spaceBetween: 16,
			},
			1024: {
				slidesPerView: 3,
			},
			1200: {
				spaceBetween: 24,
			},
		}
	});
	
	const timelineSwiper = new Swiper(".timeline__swiper", {
		slidesPerView: 'auto',
		spaceBetween: 0,
		breakpoints: {
			1200: {
				slidesPerView: 5,
			},
		}
	});

	const feedbackSwiper = new Swiper(".feedback__swiper", {
		slidesPerView: 1,
		spaceBetween: 16,
		loop: true,
		navigation: {
			nextEl: '.feedback__arrows-next',
			prevEl: '.feedback__arrows-prev',
		},
		breakpoints: {
			576: {
				slidesPerView: 2,
			},
			1024: {
				slidesPerView: 3,
				spaceBetween: 24,
			},
			1200: {
				slidesPerView: 3,
				spaceBetween: 32,
			},
		}
	});

	document.querySelectorAll('.services__accardion').forEach(accordion => {
		accordion.querySelectorAll('.services__accardion-header').forEach(header => {
			header.addEventListener('click', () => {
				const currentItem = header.closest('.services__accardion-item');

				accordion.querySelectorAll('.services__accardion-item').forEach(item => {
					item.classList.remove('active');
				});

				currentItem.classList.add('active');
			});
		});
	});

	const phantomTabs = document.querySelector('.phantom__tabs');
	const phantomTabList = phantomTabs?.querySelector('ul');
	const phantomTabLinks = phantomTabs?.querySelectorAll('a');
	const phantomIndicator = phantomTabs?.querySelector('.phantom__tabs-indicator');

	const phantomItems = document.querySelectorAll('.phantom__item');

	if (phantomTabs && phantomTabList && phantomTabLinks && phantomIndicator) {

		const updateIndicator = (tab, animate = true) => {
			const tabRect = tab.getBoundingClientRect();
			const listRect = phantomTabList.getBoundingClientRect();

			if (!animate) {
				phantomIndicator.style.transition = 'none';
			}

			phantomIndicator.style.width = `${tabRect.width}px`;
			phantomIndicator.style.transform = `translateX(${tabRect.left - listRect.left}px)`;

			if (!animate) {
				requestAnimationFrame(() => {
					phantomIndicator.style.transition = '';
				});
			}
		};

		const activateTab = (tab, animate = true) => {
			const target = tab.dataset.tab;

			// Tabs
			phantomTabLinks.forEach(item => {
				item.classList.toggle(
					'active',
					item === tab
				);
			});

			// Content
			phantomItems.forEach(item => {
				item.classList.toggle(
					'active',
					item.dataset.tabContent === target
				);
			});

			// Indicator
			updateIndicator(tab, animate);
		};

		const activeTab = phantomTabs.querySelector('a.active');

		if (activeTab) {
			activateTab(activeTab, false);
		}

		phantomTabLinks.forEach(tab => {
			tab.addEventListener('click', event => {
				event.preventDefault();

				activateTab(tab);

				tab.scrollIntoView({
					behavior: 'smooth',
					block: 'nearest',
					inline: 'center'
				});
			});
		});

		window.addEventListener('resize', () => {
			const activeTab = phantomTabs.querySelector('a.active');

			if (activeTab) {
				updateIndicator(activeTab, false);
			}
		});
	}

	const mediaQuery = window.matchMedia('(min-width: 1025px)');

	document.querySelectorAll('.dropdown').forEach((dropdown) => {
		const tabs = dropdown.querySelectorAll('.dropdown__tabs-list .dropdown__link');
		const navs = dropdown.querySelectorAll('.dropdown__nav');

		const activateTab = (index) => {
			tabs.forEach((item, i) => {
				item.classList.toggle('active', i === index);
			});

			navs.forEach((nav, i) => {
				nav.classList.toggle('active', i === index);
			});
		};

		tabs.forEach((tab, index) => {
			const handleMouseEnter = () => {
				if (window.matchMedia('(hover: hover)').matches) {
					activateTab(index);
				}
			};

			const handleClick = () => {
				activateTab(index);
			};

			tab.addEventListener('mouseenter', handleMouseEnter);
			tab.addEventListener('click', handleClick);

			tab._dropdownHandlers = {
				handleMouseEnter,
				handleClick,
			};
		});

		const updateDropdown = () => {
			tabs.forEach((tab) => {
				const handlers = tab._dropdownHandlers;

				if (mediaQuery.matches) {
					tab.addEventListener('mouseenter', handlers.handleMouseEnter);
					tab.addEventListener('click', handlers.handleClick);
				} else {
					tab.removeEventListener('mouseenter', handlers.handleMouseEnter);
					tab.removeEventListener('click', handlers.handleClick);
				}
			});
		};

		// Прибираємо початкові обробники, якщо ширина <= 768px
		updateDropdown();

		mediaQuery.addEventListener('change', updateDropdown);
	});

	const slider = document.querySelector('.blog__filter-category');
	const blogSort = document.querySelector('.blog__filter-sort');

	if (blogSort) {
		blogSort.addEventListener('change', () => {
			blogSort.form?.submit();
		});
	}

	if (slider) {
		let isDown = false;
		let startX = 0;
		let scrollLeft = 0;
		let isDragging = false;

		slider.addEventListener('mousedown', (e) => {
			if (e.button !== 0) return;

			isDown = true;
			isDragging = false;

			startX = e.pageX;
			scrollLeft = slider.scrollLeft;
		});

		slider.addEventListener('mousemove', (e) => {
			if (!isDown) return;

			const walk = e.pageX - startX;

			if (Math.abs(walk) > 5) {
				isDragging = true;
				slider.classList.add('is-dragging');
				slider.scrollLeft = scrollLeft - walk;
			}
		});

		const stopDragging = () => {
			isDown = false;
			slider.classList.remove('is-dragging');

			if (isDragging) {
				setTimeout(() => {
					isDragging = false;
				}, 0);
			}
		};

		slider.addEventListener('mouseup', stopDragging);
		slider.addEventListener('mouseleave', stopDragging);

		slider.addEventListener('click', (e) => {
			if (isDragging) {
				e.preventDefault();
				e.stopPropagation();
				isDragging = false;
			}
		}, true);
	}

	const awardsFilter = document.querySelector('[data-awards-filter]');

	if (awardsFilter) {
		const filterLinks = awardsFilter.querySelectorAll('[data-award-platform]');
		const awardItems = awardsFilter.querySelectorAll('[data-award-item]');
		const yearGroups = awardsFilter.querySelectorAll('[data-award-year]');

		const applyAwardsFilter = (platform) => {
			const available = Array.from(filterLinks).some((link) => link.dataset.awardPlatform === platform);
			const activePlatform = available ? platform : 'all';

			filterLinks.forEach((link) => {
				link.classList.toggle('active', link.dataset.awardPlatform === activePlatform);
			});

			awardItems.forEach((item) => {
				item.hidden = activePlatform !== 'all' && item.dataset.platform !== activePlatform;
			});

			yearGroups.forEach((group) => {
				group.hidden = !group.querySelector('[data-award-item]:not([hidden])');
			});
		};

		filterLinks.forEach((link) => {
			link.addEventListener('click', (event) => {
				event.preventDefault();
				const platform = link.dataset.awardPlatform;
				const url = new URL(window.location.href);

				if (platform === 'all') {
					url.searchParams.delete('platform');
				} else {
					url.searchParams.set('platform', platform);
				}

				window.history.replaceState({}, '', url);
				applyAwardsFilter(platform);
			});
		});

		applyAwardsFilter(new URL(window.location.href).searchParams.get('platform') || 'all');
	}

	const postContent = document.querySelector('.post__content');
	const progress = document.querySelector('.post__progress-line-current');
	if (postContent && progress) {
		let progressScheduled = false;
		const updateProgress = () => {
			const bounds = postContent.getBoundingClientRect();
			const distance = bounds.height - window.innerHeight;
			const ratio = distance > 0 ? -bounds.top / distance : (bounds.top <= 0 ? 1 : 0);
			progress.style.width = `${Math.min(1, Math.max(0, ratio)) * 100}%`;
			progressScheduled = false;
		};
		const scheduleProgress = () => {
			if (!progressScheduled) {
				progressScheduled = true;
				window.requestAnimationFrame(updateProgress);
			}
		};
		window.addEventListener('scroll', scheduleProgress, { passive: true });
		window.addEventListener('resize', scheduleProgress);
		if (window.ResizeObserver) new ResizeObserver(scheduleProgress).observe(postContent);
		updateProgress();
	}

	const copyText = async (text) => {
		try {
			if (navigator.clipboard && window.isSecureContext) {
				await navigator.clipboard.writeText(text);
				return true;
			}
		} catch (error) { /* Try the fallback when clipboard access is unavailable. */ }
		const activeElement = document.activeElement;
		const selection = window.getSelection();
		const ranges = selection ? Array.from({ length: selection.rangeCount }, (_, index) => selection.getRangeAt(index).cloneRange()) : [];
		const input = document.createElement('textarea');
		input.value = text;
		input.style.position = 'fixed';
		input.style.opacity = '0';
		document.body.appendChild(input);
		input.select();
		let copied = false;
		try { copied = document.execCommand('copy'); } catch (error) { copied = false; }
		input.remove();
		if (activeElement instanceof HTMLElement) activeElement.focus({ preventScroll: true });
		if (selection) {
			selection.removeAllRanges();
			ranges.forEach((range) => selection.addRange(range));
		}
		return copied;
	};

	const codeCopyTimers = new WeakMap();
	document.addEventListener('click', async (event) => {
		const button = event.target instanceof Element ? event.target.closest('[data-copy-code]') : null;
		if (!button) return;
		const panel = button.closest('.post__code');
		const code = panel ? panel.querySelector('.post__code-content code') : null;
		const status = panel ? panel.querySelector('[data-code-status]') : null;
		if (!code || !status) return;
		const copied = await copyText(code.textContent);
		window.clearTimeout(codeCopyTimers.get(button));
		status.textContent = copied ? button.dataset.copySuccess : button.dataset.copyError;
		button.classList.toggle('is-copied', copied);
		button.setAttribute('aria-label', copied ? button.dataset.copySuccess : button.dataset.copyLabel);
		button.title = copied ? button.dataset.copySuccess : button.dataset.copyLabel;
		codeCopyTimers.set(button, window.setTimeout(() => {
			status.textContent = '';
			button.classList.remove('is-copied');
			button.setAttribute('aria-label', button.dataset.copyLabel);
			button.title = button.dataset.copyLabel;
		}, copied ? 2500 : 5000));
	});

	document.querySelectorAll('[data-copy-post-link]').forEach((link) => {
		link.addEventListener('click', async (event) => {
			event.preventDefault();
			const copied = await copyText(link.href);
			const share = link.closest('.post__share, .share');
			const status = share ? share.querySelector('[data-copy-status]') : null;
			if (copied && status) {
				status.textContent = link.dataset.copiedLabel;
				window.setTimeout(() => { status.textContent = ''; }, 2500);
			} else if (!copied) {
				window.prompt(link.getAttribute('aria-label'), link.href);
			}
		});
	});

	document.querySelectorAll('.toc').forEach((toc) => {
		const links = Array.from(toc.querySelectorAll('a[href^="#"]'));
		const sections = links
			.map((link) => document.getElementById(decodeURIComponent(link.hash.slice(1))))
			.filter(Boolean);

		if (!sections.length) return;

		const setActiveLink = (id) => {
			links.forEach((link) => {
				link.classList.toggle('active', decodeURIComponent(link.hash.slice(1)) === id);
			});
		};

		setActiveLink(sections[0].id);
		const observer = new IntersectionObserver((entries) => {
			const visible = entries
				.filter((entry) => entry.isIntersecting)
				.sort((a, b) => a.boundingClientRect.top - b.boundingClientRect.top);

			if (visible.length) setActiveLink(visible[0].target.id);
		}, { rootMargin: '-20% 0px -65% 0px', threshold: 0 });

		sections.forEach((section) => observer.observe(section));
	});

});
