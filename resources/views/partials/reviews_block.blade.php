<div class="comments-area">
    <div class="row">
        <div class="col-lg-8">
            <h4 class="mb-30">Customer questions & answers</h4>
            <div class="comment-list comment-list-custom row">
                @foreach ($mainProduct_reviews as $review)
                    @php
                        $rating = $review->ratings ?? 0;
                    @endphp
                    <div class="col-md-6">
                        <div class="single-comment mb-3 border-bottom">
                            <div class="d-flex align-items-center mb-2">
                                <div class="me-2 d-flex">
                                    <img src="{{ asset('assets/frontend/imgs/blog/author-2.png') }}" alt="">
                                </div>
                                <div>
                                    <h6 class="mb-0 font-heading text-brand"
                                        style="font-size: 14px; font-weight: bold;">
                                        {{ $review->name }}
                                    </h6>
                                </div>
                            </div>

                            <div class="d-flex align-items-center mb-2">
                                <div class="stars me-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $rating)
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star text-muted"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>

                            <div class="desc">
                                <p class="mb-0 text-secondary fs-14" style="line-height: 1.3;">
                                    {{ $review->remarks }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-lg-4">
            @php
                $total_reviews = $mainProduct_reviews->count();
                $average_rating = $total_reviews > 0 ? $mainProduct_reviews->avg('ratings') : 0;

                $star_counts = [
                    5 => $mainProduct_reviews->where('ratings', 5)->count(),
                    4 => $mainProduct_reviews->where('ratings', 4)->count(),
                    3 => $mainProduct_reviews->where('ratings', 3)->count(),
                    2 => $mainProduct_reviews->where('ratings', 2)->count(),
                    1 => $mainProduct_reviews->where('ratings', 1)->count(),
                ];

                $star_percentages = [];
                foreach ($star_counts as $star => $count) {
                    $star_percentages[$star] = $total_reviews > 0 ? round(($count / $total_reviews) * 100, 1) : 0;
                }

                $average_percentage = ($average_rating / 5) * 100;
            @endphp
            <div class="position-sticky" style="top: 13%">
                <h4 class="mb-30">Customer reviews</h4>

                <div class="d-flex mb-30 align-items-center">
                    <div class="product-rate d-inline-block mr-15">
                        <div class="product-rating" style="width: {{ $average_percentage }}%"></div>
                    </div>
                    <h6>{{ number_format($average_rating, 1) }} out of 5</h6>
                </div>

                @foreach ([5, 4, 3, 2, 1] as $star)
                    <div class="progress mb-2">
                        <span>{{ $star }} star</span>
                        <div class="progress-bar" role="progressbar" style="width: {{ $star_percentages[$star] }}%"
                            aria-valuenow="{{ $star_percentages[$star] }}" aria-valuemin="0" aria-valuemax="100">
                            {{ $star_percentages[$star] }}%
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
