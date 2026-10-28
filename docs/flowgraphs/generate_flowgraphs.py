import matplotlib.pyplot as plt
import matplotlib.patches as patches
import math

def create_flowgraph_login(output_path):
    # Proportional figure size matching the spacing of the other flowgraphs
    fig, ax = plt.subplots(figsize=(4.5, 8.5), dpi=300)
    ax.set_xlim(-1.2, 1.4)
    ax.set_ylim(0.2, 7.8)
    ax.axis('off')

    nodes = {
        1: (0, 7),
        2: (0, 6),
        3: (0, 5),
        4: (0, 4),
        5: (0, 3),
        6: (0, 2),
        7: (0, 1),
    }

    r = 0.35

    # Straight down edges
    straight_edges = [(1, 2), (2, 3), (3, 4), (4, 5), (5, 6), (6, 7)]
    for u, v in straight_edges:
        x1, y1 = nodes[u]
        x2, y2 = nodes[v]
        ax.annotate('', xy=(x2, y2 + r), xytext=(x1, y1 - r),
                    arrowprops=dict(arrowstyle="->", color="black", lw=1.6, shrinkA=0, shrinkB=0, mutation_scale=15))

    # Clean return loop from 5 back to 2 (pure lines & arrow, exactly like Gambar 2 in PDF)
    loop_x = 0.75
    # horizontal from 5
    ax.plot([r, loop_x], [nodes[5][1], nodes[5][1]], color="black", lw=1.6)
    # vertical up
    ax.plot([loop_x, loop_x], [nodes[5][1], nodes[2][1]], color="black", lw=1.6)
    # horizontal into 2 with arrow
    ax.annotate('', xy=(r, nodes[2][1]), xytext=(loop_x, nodes[2][1]),
                arrowprops=dict(arrowstyle="->", color="black", lw=1.6, shrinkA=0, shrinkB=0, mutation_scale=15))

    # Draw circular nodes (identical styling to the other 2 flowgraphs)
    for node_id, (x, y) in nodes.items():
        circle = patches.Circle((x, y), r, facecolor='white', edgecolor='black', linewidth=1.8, zorder=5)
        ax.add_patch(circle)
        ax.text(x, y, str(node_id), fontsize=12, fontweight='bold', ha='center', va='center', zorder=6)

    plt.title('Flowgraph Login', fontsize=13, fontweight='bold', pad=12)
    plt.tight_layout()
    plt.savefig(output_path, bbox_inches='tight', facecolor='white')
    plt.close()
    print(f"Saved {output_path}")

def create_flowgraph_pemrosesan_kml(output_path):
    fig, ax = plt.subplots(figsize=(5.5, 12), dpi=300)
    ax.set_xlim(-1.8, 1.8)
    ax.set_ylim(0.2, 12.8)
    ax.axis('off')

    nodes = {
        1: (0, 12),
        2: (0, 11),
        3: (-1.1, 10),
        4: (1.1, 10),
        5: (0, 9),
        6: (0, 8),
        7: (0, 7),
        8: (0, 6),
        9: (0, 5),
        10: (0, 4),
        11: (-1.1, 3),
        12: (1.1, 3),
        13: (0, 2),
        14: (0, 1)
    }

    edges = [
        (1, 2),
        (2, 3), (2, 4),
        (3, 5), (4, 5),
        (5, 6), (6, 7), (7, 8), (8, 9), (9, 10),
        (10, 11), (10, 12),
        (11, 13), (12, 13),
        (13, 14)
    ]

    r = 0.35
    for u, v in edges:
        x1, y1 = nodes[u]
        x2, y2 = nodes[v]
        dx = x2 - x1
        dy = y2 - y1
        dist = math.hypot(dx, dy)
        sx = x1 + (dx / dist) * r
        sy = y1 + (dy / dist) * r
        ex = x2 - (dx / dist) * r
        ey = y2 - (dy / dist) * r

        ax.annotate('', xy=(ex, ey), xytext=(sx, sy),
                    arrowprops=dict(arrowstyle="->", color="black", lw=1.6, shrinkA=0, shrinkB=0, mutation_scale=15))

    for node_id, (x, y) in nodes.items():
        circle = patches.Circle((x, y), r, facecolor='white', edgecolor='black', linewidth=1.8, zorder=5)
        ax.add_patch(circle)
        ax.text(x, y, str(node_id), fontsize=11, fontweight='bold', ha='center', va='center', zorder=6)

    plt.title('Flowgraph Pemrosesan KML (Excel/PDF)', fontsize=13, fontweight='bold', pad=12)
    plt.tight_layout()
    plt.savefig(output_path, bbox_inches='tight', facecolor='white')
    plt.close()
    print(f"Saved {output_path}")

def create_flowgraph_pemetaan_baru(output_path):
    fig, ax = plt.subplots(figsize=(5.0, 11), dpi=300)
    ax.set_xlim(-1.6, 1.6)
    ax.set_ylim(0.2, 9.8)
    ax.axis('off')

    nodes = {
        1: (0, 9),
        2: (0, 8),
        3: (0, 7),
        4: (0, 6),
        5: (0, 5),
        6: (0, 4),
        7: (-1.0, 3),
        8: (1.0, 3),
        9: (-1.0, 2),
        10: (1.0, 2),
        11: (0, 1)
    }

    edges = [
        (1, 2), (2, 3), (3, 4), (4, 5), (5, 6),
        (6, 7), (6, 8),
        (7, 9), (8, 10),
        (9, 11), (10, 11)
    ]

    r = 0.35
    for u, v in edges:
        x1, y1 = nodes[u]
        x2, y2 = nodes[v]
        dx = x2 - x1
        dy = y2 - y1
        dist = math.hypot(dx, dy)
        sx = x1 + (dx / dist) * r
        sy = y1 + (dy / dist) * r
        ex = x2 - (dx / dist) * r
        ey = y2 - (dy / dist) * r

        ax.annotate('', xy=(ex, ey), xytext=(sx, sy),
                    arrowprops=dict(arrowstyle="->", color="black", lw=1.6, shrinkA=0, shrinkB=0, mutation_scale=15))

    for node_id, (x, y) in nodes.items():
        circle = patches.Circle((x, y), r, facecolor='white', edgecolor='black', linewidth=1.8, zorder=5)
        ax.add_patch(circle)
        ax.text(x, y, str(node_id), fontsize=11, fontweight='bold', ha='center', va='center', zorder=6)

    plt.title('Flowgraph Pemetaan KML Baru', fontsize=13, fontweight='bold', pad=12)
    plt.tight_layout()
    plt.savefig(output_path, bbox_inches='tight', facecolor='white')
    plt.close()
    print(f"Saved {output_path}")

if __name__ == '__main__':
    create_flowgraph_login('docs/flowgraphs/flowgraph_login.png')
    create_flowgraph_pemrosesan_kml('docs/flowgraphs/flowgraph_pemrosesan_kml.png')
    create_flowgraph_pemetaan_baru('docs/flowgraphs/flowgraph_pemetaan_baru.png')
