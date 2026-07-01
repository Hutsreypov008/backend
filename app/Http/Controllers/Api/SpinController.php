<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SpinReward;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SpinController extends Controller
{
    /**
     * Prize configuration with weighted probabilities.
     * Higher weight = more likely to land.
     */
    private array $prizes = [
        ['type' => 'discount_30', 'percent' => 30, 'weight' => 5],
        ['type' => 'free_gift',   'percent' => null, 'weight' => 10],
        ['type' => 'discount_20', 'percent' => 20, 'weight' => 15],
        ['type' => 'discount_10', 'percent' => 10, 'weight' => 30],
        ['type' => 'discount_5',  'percent' => 5,  'weight' => 40],
    ];

    /**
     * Check if the current user can spin (no existing spin reward).
     */
    public function status(Request $request)
    {
        $user = $request->user();
        $existing = SpinReward::where('user_id', $user->id)->first();

        return response()->json([
            'can_spin' => is_null($existing),
            'reward' => $existing ? [
                'prize_type' => $existing->prize_type,
                'discount_percent' => $existing->discount_percent,
                'coupon_code' => $existing->coupon_code,
                'is_used' => $existing->is_used,
                'expires_at' => $existing->expires_at,
                'is_valid' => $existing->isValid(),
            ] : null,
        ]);
    }

    /**
     * Perform the spin and generate a reward.
     */
    public function spin(Request $request)
    {
        $user = $request->user();

        // Already has a reward — can't spin again
        if (SpinReward::where('user_id', $user->id)->exists()) {
            return response()->json([
                'message' => 'You have already claimed your welcome reward.',
            ], 422);
        }

        // Pick a weighted random prize
        $prize = $this->pickPrize();

        // Generate a unique coupon code
        $couponCode = 'WELCOME-' . strtoupper(Str::random(8));

        $reward = SpinReward::create([
            'user_id' => $user->id,
            'prize_type' => $prize['type'],
            'discount_percent' => $prize['percent'],
            'coupon_code' => $couponCode,
            'expires_at' => now()->addDays(30),
        ]);

        return response()->json([
            'message' => 'Congratulations! Spin successful.',
            'reward' => [
                'prize_type' => $reward->prize_type,
                'discount_percent' => $reward->discount_percent,
                'coupon_code' => $reward->coupon_code,
                'expires_at' => $reward->expires_at,
                'is_used' => false,
            ],
        ], 201);
    }

    /**
     * Get the current user's active reward.
     */
    public function myReward(Request $request)
    {
        $reward = SpinReward::where('user_id', $request->user()->id)->first();

        if (!$reward) {
            return response()->json(['reward' => null]);
        }

        return response()->json([
            'reward' => [
                'prize_type' => $reward->prize_type,
                'discount_percent' => $reward->discount_percent,
                'coupon_code' => $reward->coupon_code,
                'is_used' => $reward->is_used,
                'expires_at' => $reward->expires_at,
                'is_valid' => $reward->isValid(),
            ],
        ]);
    }

    /**
     * Pick a prize based on weighted probabilities.
     */
    private function pickPrize(): array
    {
        $totalWeight = array_sum(array_column($this->prizes, 'weight'));
        $rand = mt_rand(1, $totalWeight);
        $cumulative = 0;

        foreach ($this->prizes as $prize) {
            $cumulative += $prize['weight'];
            if ($rand <= $cumulative) {
                return $prize;
            }
        }

        // Fallback (should never reach here)
        return $this->prizes[count($this->prizes) - 1];
    }
}
