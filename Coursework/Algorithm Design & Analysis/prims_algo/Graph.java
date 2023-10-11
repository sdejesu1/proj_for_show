// jdh CS224 Spring 2023
// Steven De Jesus (prim() & primPQ)

import java.util.List;
import java.util.ArrayList;
import java.util.PriorityQueue;

public class Graph {
    List<Node> nodes;

    //---------------------------------------------------

    public Graph() {
        nodes = new ArrayList<Node>();
    }

    //---------------------------------------------------

    public void addNode(Node node) {
        for (Node n : this.nodes) {
            if (n == node) {
                System.out.println("ERROR: graph already has a node " + n.name);
                assert false;
            }
        }
        this.nodes.add(node);
    }

    //---------------------------------------------------

    public void addEdge(Node n1, Node n2, int weight) {
        // outgoing edge
        int idx1 = this.nodes.indexOf(n1);
        if (idx1 < 0) {
            System.out.println("ERROR: node " + n1.name + " not found in graph");
            assert false;
        }

        int idx2 = this.nodes.indexOf(n2);
        if (idx2 < 0) {
            System.out.println("ERROR: node " + n2.name + " not found in graph");
            assert false;
        }

        Edge e1 = new Edge(n1, n2, weight);
        this.nodes.get(idx1).add(e1);

        Edge e2 = new Edge(n2, n1, weight);
        this.nodes.get(idx2).add(e2);
    }

    //-----------------------------------------------

    public List<Edge> prim(Node s) {
        // implement this
        List<Edge> result = new ArrayList<>();
        int totalWeight = 0;

        List<Node> S = new ArrayList<>();
        S.add(s);

        while (S.size() != nodes.size()) {
            Edge minEdge = null;

            for (Node n : S) {
                for (Edge e : n.adjlist) {
                    if (S.contains(e.n1) && !S.contains(e.n2)) {
                        if (minEdge == null || e.weight < minEdge.weight) {
                            minEdge = e;
                        }
                    } else if (S.contains(e.n2) && !S.contains(e.n1)) {
                        if (minEdge == null || e.weight < minEdge.weight) {
                            minEdge = e;
                        }
                    }
                }
            }

            if (minEdge != null) {
                result.add(minEdge);
                totalWeight += minEdge.weight;
                Node nextNode = S.contains(minEdge.n1) ? minEdge.n2 : minEdge.n1;
                S.add(nextNode);
            }
        }

        System.out.println("Total weight: " + totalWeight);
        return result;

    } // prim()

    //-----------------------------------------------

    public List<Edge> primPQ(Node s) {
        // implement this
        int totalWeight = 0;
        List<Edge> mst = new ArrayList<Edge>();
        boolean[] selected = new boolean[nodes.size()];
        Edge[] minEdge = new Edge[nodes.size()];

        // initialize all nodes except s with a large priority
        for (Node n : nodes) {
            if (n != s) {
                n.priority = Integer.MAX_VALUE;
            }
        }

        // add all nodes to the priority queue
        PriorityQueue<Node> pq = new PriorityQueue<Node>();
        for (Node n : nodes) {
            pq.add(n);
        }

        while (!pq.isEmpty()) {
            Node u = pq.poll();
            selected[u.name - 1] = true;

            // add edge to MST
            if (minEdge[u.name - 1] != null) {
                mst.add(minEdge[u.name - 1]);
                totalWeight += minEdge[u.name - 1].weight;
            }

            for (Edge e : u.adjlist) {
                Node v = e.n2;
                if (!selected[v.name - 1] && e.weight < v.priority) {
                    // update priority and minEdge
                    v.priority = e.weight;
                    minEdge[v.name - 1] = e;
                }
            }

            // update priority queue
            pq.clear();
            for (Node n : nodes) {
                if (!selected[n.name - 1]) {
                    pq.add(n);
                }
            }

        }

        System.out.println("Total Weight:" + totalWeight);

        return mst;
    }

} // primPQ()
 // class Graph
